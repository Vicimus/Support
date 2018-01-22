<?php declare(strict_types = 1);

namespace Vicimus\Support\Traits;

use GuzzleHttp\Psr7\Response;
use Vicimus\Support\Classes\ImmutableObject;

trait TransformsResponses
{
    /**
     * Transform a response into an immutable object instance
     *
     * @param Response $response
     * @param string   $class
     *
     * @return Collection|ImmutableObject[]|ImmutableObject
     */
    public function transformResponse(Response $response, string $class)
    {
        $decoded = (string) $response->getBody();
        if (!is_array($decoded)) {
            $decoded = [$decoded];
        }

        $payload = [];
        foreach ($decoded as $row) {
            $payload[] = new $class($row);
        }

        if (count($payload) === 1) {
            return $payload[0];
        }

        return new Collection($payload);
    }
}
