<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;
use Vicimus\Support\Exceptions\RestException;

/**
 * Class APIService
 *
 * @package Vicimus\Support\Classes
 */
class APIService
{
    /**
     * These additional parameters will be sent with all requests
     *
     * @var string[]
     */
    protected $additional = [];
    /**
     * The guzzle client
     *
     * @var Client
     */
    protected $client;

    /**
     * The base url of the api
     *
     * @var string
     */
    protected $url;

    /**
     * Credentials for sending api requests
     *
     * @var string
     */
    private $cred;

    /**
     * APIService constructor.
     *
     * @param Client   $client     The guzzle client
     * @param string   $url        The base url for the api
     * @param string   $id         The ID for the API
     * @param string   $secret     The Secret for the API
     * @param string[] $additional Additional parameters to send with all requests
     */
    public function __construct(
        Client $client,
        string $url,
        ?string $id = null,
        ?string $secret = null,
        array $additional = []
    ) {
        $this->client = $client;
        $this->url = $url;
        $this->cred = base64_encode($id . ':' . $secret);
        $this->additional = $additional;
    }

    /**
     * Send a request to the API
     *
     * @param string          $method  The method to use
     * @param string          $path    The path to call
     * @param string[]|object $payload The payload to send
     *
     * @throws RestException
     *
     * @return mixed[]|\stdClass
     */
    protected function request(string $method, string $path, $payload = [])
    {
        if (!is_array($payload)) {
            $payload = json_decode(json_encode($payload), true);
        }

        $path = str_replace($this->url, '', $path);
        if (substr($path, 0, 1) !== '/') {
            $path = '/'.$path;
        }

        $query = 'query';
        if (strtolower($method) !== 'get') {
            $query = 'form_params';
        }

        $payload = array_merge($this->additional, $payload);

        try {
            $response = $this->client->request($method, $this->url . $path, [
                'headers' => ['authorization' => $this->cred],
                $query => $payload,
            ]);
        } catch (ClientException|ServerException $ex) {
            $response = $ex->getResponse();
            $code = $response->getStatusCode();
            $message = (string) $response->getBody();
            $decoded = json_decode($message, true);
            if ($decoded) {
                $message = $decoded['error'] ?? $message;
            }

            throw new RestException($message, $code);
        }

        return json_decode((string) $response->getBody());
    }
}
