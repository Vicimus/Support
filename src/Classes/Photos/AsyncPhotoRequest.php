<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vicimus\Support\Classes\API\AsyncRequest;
use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

class AsyncPhotoRequest implements AsyncRequest
{
    public function __construct(
        protected readonly Vehicle $vehicle,
        protected readonly Photo $photo,
        protected readonly ?PhotoStatus $status = null,
        protected string $verb = 'GET',
    ) {
        $this->verb = strtoupper($verb);
    }

    /**
     * Get a property of the request or null if it has not been set
     */
    public function get(string $property): mixed
    {
        if (!property_exists($this, $property)) {
            return null;
        }

        return $this->$property;
    }

    /**
     * Get the request to make
     */
    public function getRequest(): Request
    {
        return new Request($this->verb, $this->photo->origin());
    }

    /**
     * Process the response. If a value is returned, it will be added
     * to the response collection.
     *
     * If NULL is returned, the response will be ignored
     */
    public function process(Response $response): ?PhotoStatus
    {
        $status = $this->photo->status(new Headers($response), $this->vehicle);
        if ($status->isOutdated()) {
            return $status;
        }

        return null;
    }

    /**
     * Calling this method will set the request verb. How that is implemented
     * is up to the developer
     */
    public function verb(string $verb): void
    {
        $this->verb = $verb;
    }
}
