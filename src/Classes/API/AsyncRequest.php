<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Interface AsyncRequest
 */
interface AsyncRequest
{
    /**
     * Get a property of the request or null if it has not been set
     *
     * @param string $property The property to try and get
     *
     */
    public function get(string $property): mixed;

    /**
     * Get the request to make
     *
     */
    public function getRequest(): Request;

    /**
     * Process the response. If a value is returned, it will be added
     * to the response collection.
     *
     * If NULL is returned, the response will be ignored
     *
     * @param Response $response THe response from the request
     *
     */
    public function process(Response $response): mixed;

    /**
     * Calling this method will set the request verb. How that is implemented
     * is up to the developer
     *
     * @param string $verb The verb to set
     *
     */
    public function verb(string $verb): void;
}
