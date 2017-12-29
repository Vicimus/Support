<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\API;

use GuzzleHttp\Psr7\Response;
use Vicimus\Support\Classes\ImmutableObject;

/**
 * Specializes in interacting with response headers
 * from a Guzzle request
 *
 * @property string $etag
 */
class Headers extends ImmutableObject
{
    /**
     * Headers constructor
     *
     * @param Response $response A response from the server
     */
    public function __construct(Response $response)
    {
        $headers = $response->getHeaders();
        $payload = [];
        foreach ($headers as $header => $contents) {
            $payload[strtolower($header)] = implode("\n", $contents);
        }

        parent::__construct($payload);
    }

    /**
     * For headers you can't access magically because of dashes
     *
     * @param string $header The header to get
     *
     * @return string
     */
    public function get(string $header): ?string
    {
        return $this->attributes[$header] ?? null;
    }
}
