<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use InvalidArgumentException;
use Vicimus\Support\Classes\API\MultipartPayload;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Exceptions\ServerException;
use Vicimus\Support\Exceptions\UnauthorizedException;

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
     * Take in an array of multipart payloads and format them into
     * a structure that Guzzle can take and send
     *
     * @param MultipartPayload[] $payload The payload to format
     *
     * @return mixed[]
     */
    protected function format(array $payload): array
    {
        $formatted = [];
        foreach ($payload as $item) {
            $formatted[] = $item->format();
        }

        return $formatted;
    }
    /**
     * Make a multi-part request to the vault
     *
     * @param string             $path    The path to post to
     * @param MultipartPayload[] $payload The payload to send
     * @param string             $verb    The http verb to use
     *
     * @throws UnauthorizedException on 401
     * @throws ServerException on 500
     *
     * @return mixed
     */
    protected function multipart(string $path, array $payload, string $verb = 'POST')
    {
        $this->validate($payload);

        if ($verb === 'PATCH') {
            $payload[] = new MultipartPayload('_method', $verb);
            $verb = 'POST';
        }

        $response = null;
        $multipart = $this->format($payload);

        $path = str_replace($this->url, '', $path);
        if (substr($path, 0, 1) !== '/') {
            $path = '/' . $path;
        }

        try {
            $response = $this->client->$verb($this->url . $path, [
                'headers' => [
                    'authorization' => $this->cred,
                ],
                'multipart' => $multipart,
            ]);

            return json_decode((string) $response->getBody());
        } catch (ClientException $ex) {
            if ($ex->getCode()) {
                $response = array_values(
                    json_decode((string) $ex->getResponse()->getBody(), true)
                )[0];
                throw new UnauthorizedException($response, $ex->getResponse()->getStatusCode());
            }
        } catch (GuzzleServerException $ex) {
            $response = (string) $ex->getResponse()->getBody();
            throw new ServerException($response, $ex->getResponse()->getStatusCode());
        }

        return $response;
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
            $path = '/' . $path;
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

    /**
     * Result multipart payloads
     *
     * @param MultipartPayload[] $payload The payload to validate
     *
     * @return void
     */
    protected function validate(array $payload): void
    {
        foreach ($payload as $row) {
            if (!$row instanceof MultipartPayload) {
                $type = is_object($row) ? get_class($row) : gettype($row);
                throw new InvalidArgumentException(
                    sprintf(
                        '$payload must be an array of %s, got [%s]',
                        MultipartPayload::class,
                        $type
                    )
                );
            }
        }
    }

}