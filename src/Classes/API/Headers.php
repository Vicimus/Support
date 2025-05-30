<?php

declare(strict_types=1);

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
    public function __construct(
        Response $response
    ) {
        $headers = $response->getHeaders();
        $payload = [];
        foreach ($headers as $header => $contents) {
            if (is_array($contents)) {
                $contents = implode("\n", $contents);
            }

            $payload[strtolower($header)] = $contents;
        }

        parent::__construct($payload);
    }

    public function get(string $header): ?string
    {
        return $this->attributes[$header] ?? null;
    }
}
