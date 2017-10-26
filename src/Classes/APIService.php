<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Vicimus\Support\Exceptions\RestException;

/**
 * Class APIService
 *
 * @package Vicimus\Support\Classes
 */
class APIService
{
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
     * APIService constructor.
     *
     * @param Client $client The guzzle client
     * @param string $url    The base url for the api
     */
    public function __construct(Client $client, ?string $url = null)
    {
        $this->client = $client;
        $this->url = $url ?? 'http://leads.dv-3.com';
    }

    /**
     * Send a request to the API
     *
     * @param string   $method  The method to use
     * @param string   $path    The path to call
     * @param string[] $payload The payload to send
     *
     * @throws RestException
     *
     * @return mixed[]|\stdClass
     */
    protected function request(string $method, string $path, array $payload = [])
    {
        $path = str_replace($this->url, '', $path);
        if (substr($path, 0, 1) !== '/') {
            $path = '/'.$path;
        }

        try {
            $response = $this->client->request($method, $this->url . $path, $payload);
        } catch (ClientException $ex) {
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
