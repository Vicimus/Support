<?php

declare(strict_types=1);

namespace Vicimus\Support\Traits;

use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Collection;
use stdClass;
use Vicimus\Support\Classes\ImmutableObject;

trait TransformsResponses
{
    /**
     * Transform a response into an immutable object instance
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param Response|stdClass|mixed[] $response The response to transform
     * @param string                    $class    The class to transform to
     * @param string                    $mode     The transform mode
     *
     * @return Collection<ImmutableObject> | ImmutableObject
     */
    public function transformResponse(
        Response | stdClass | array $response,
        string $class,
        ?string $mode = null,
    ): Collection | ImmutableObject {
        if ($response instanceof Response) {
            $response = (string) $response->getBody();
        }

        if (!is_array($response)) {
            $response = [$response];
        }

        $payload = [];
        foreach ($response as $row) {
            $payload[] = new $class($row);
        }

        if ($mode !== 'collection' && count($payload) === 1) {
            return $payload[0];
        }

        return new Collection($payload);
    }
}
