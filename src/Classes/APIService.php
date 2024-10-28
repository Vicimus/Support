<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException as GuzzleServerException;
use GuzzleHttp\Psr7\Response;
use Psr\SimpleCache\InvalidArgumentException as CacheInvalidArgumentException;
use stdClass;
use Vicimus\Support\Classes\API\CachesRequests;
use Vicimus\Support\Classes\API\MultipartPayload;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Exceptions\ServerException;
use Vicimus\Support\Exceptions\UnauthorizedException;

class APIService
{
    use CachesRequests;

    /**
     * These additional parameters will be sent with all requests
     * @var string[]
     */
    protected array $additional = [];

    /**
     * The guzzle client
     */
    protected ClientInterface $client;

    /**
     * The base url of the api
     */
    protected string $url;

    /**
     * Credentials for sending api requests
     */
    private string $cred;

    /**
     * APIService constructor.
     *
     * @param ClientInterface $client     The guzzle client
     * @param string          $url        The base url for the api
     * @param string|null     $id         The ID for the API
     * @param string|null     $secret     The Secret for the API
     * @param string[]        $additional Additional parameters to send with all requests
     */
    public function __construct(
        ClientInterface $client,
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
     * Make a multi-part request to the vault
     *
     * @param string             $path    The path to post to
     * @param MultipartPayload[] $payload The payload to send
     * @param string             $verb    The http verb to use
     *
     * @throws UnauthorizedException on 401
     * @throws ServerException on 500
     */
    public function multipart(string $path, array $payload, string $verb = 'POST'): mixed
    {
        $this->validate($payload);

        if (strtoupper($verb) === 'PATCH') {
            $payload[] = new MultipartPayload('_method', $verb);
            $verb = 'POST';
        }

        $response = null;
        $multipart = $this->format($payload);

        $path = str_replace($this->url, '', $path);
        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }

        try {
            /** @var Response $response */
            $response = $this->client->$verb($this->url . $path, [
                'headers' => [
                    'authorization' => $this->cred,
                ],
                'multipart' => $multipart,
            ]);

            $response = json_decode((string) $response->getBody(), false);
        } catch (ClientException $ex) {
            /** @var Response $rawResponse */
            $rawResponse = $ex->getResponse();
            if ($ex->getCode()) {
                $response = array_values(
                    json_decode((string) $rawResponse->getBody(), true)
                )[0];
                throw new UnauthorizedException($response, $rawResponse->getStatusCode());
            }
        } catch (GuzzleServerException $ex) {
            /** @var Response $rawResponse */
            $rawResponse = $ex->getResponse();
            $response = (string) $rawResponse->getBody();
            throw new ServerException($response, $rawResponse->getStatusCode());
        }

        return $response;
    }

    /**
     * Send a request to the API
     *
     * @param string          $method  The method to use
     * @param string          $path    The path to call
     * @param string[]|object $payload The payload to send
     * @param string|null     $tag     A special tag to use for caching
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]|stdClass
     *
     * @throws RestException
     * @throws GuzzleException
     * @throws CacheInvalidArgumentException
     */
    public function request(string $method, string $path, mixed $payload = [], ?string $tag = null): mixed
    {
        $path = str_replace($this->url, '', $path);
        if (strpos($path, '/') !== 0) {
            $path = '/' . $path;
        }

        $query = 'query';
        if (strtolower($method) !== 'get') {
            $query = 'json';
        }

        $match = $this->cacheMatch($method, $path, $payload, $tag);
        if ($match) {
            return $match;
        }

        try {
            $response = $this->client->request($method, $this->url . $path, [
                'headers' => [
                    'authorization' => $this->cred,
                    'accept' => 'application/json',
                ],
                $query => $this->payload($payload),
            ]);
        } catch (ClientException | GuzzleServerException $ex) {
            $response = $ex->getResponse();
            $code = $response->getStatusCode();
            $message = (string) $response->getBody();
            $decoded = json_decode($message, true);
            if ($decoded) {
                $message = $decoded['error'] ?? $message;
            }

            throw new RestException(is_string($message) ? $message : json_encode($message), $code);
        }

        $result = (string) $response->getBody();
        if ($this->cache) {
            $this->cache->add(
                $this->generateCacheHash($method, $path, $payload, $tag),
                $result,
                $this->cacheTime()
            );
        }

        return json_decode($result);
    }

    /**
     * Take in an array of multipart payloads and format them into
     * a structure that Guzzle can take and send
     *
     * @param MultipartPayload[] $payload The payload to format
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
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
     * Convert, validate and transform
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @return mixed[]
     */
    protected function payload(mixed $payload): array
    {
        if (!is_array($payload)) {
            $payload = json_decode(json_encode($payload), true);
        }

        return array_merge($this->additional, $payload ?? []);
    }

    /**
     * Result multipart payloads
     *
     * @param MultipartPayload[] $payload The payload to validate
     *
     * @throws InvalidArgumentException
     */
    protected function validate(array $payload): void
    {
        foreach ($payload as $row) {
            if (!$row instanceof MultipartPayload) {
                throw new InvalidArgumentException(
                    $row,
                    MultipartPayload::class
                );
            }
        }
    }
}
