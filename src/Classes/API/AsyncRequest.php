<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vicimus\Support\Classes\Photos\PhotoStatus;

interface AsyncRequest
{
    /**
     * Get a property of the request or null if it has not been set
     */
    public function get(string $property): mixed;

    /**
     * Get the request to make
     */
    public function getRequest(): Request;

    /**
     * Process the response. If a value is returned, it will be added
     * to the response collection.
     *
     * If NULL is returned, the response will be ignored
     */
    public function process(Response $response): ?PhotoStatus;

    /**
     * Calling this method will set the request verb. How that is implemented
     * is up to the developer
     */
    public function verb(string $verb): void;
}
