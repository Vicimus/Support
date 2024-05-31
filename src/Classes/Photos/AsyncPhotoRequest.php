<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Vicimus\Support\Classes\API\AsyncRequest;
use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * Class AsyncPhotoRequest
 */
class AsyncPhotoRequest implements AsyncRequest
{
    /**
     * The photo
     *
     */
    protected Photo $photo;

    /**
     * The photo this request is for
     *
     */
    protected PhotoStatus $status;

    /**
     * The vehicle this is for
     *
     */
    protected Vehicle $vehicle;

    /**
     * The verb to use
     *
     */
    protected string $verb;

    /**
     * AsyncPhotoRequest constructor.
     *
     * @param Vehicle     $vehicle The vehicle this is for
     * @param Photo       $photo   The photo
     * @param PhotoStatus $status  The status
     * @param string      $verb    The verb to use
     */
    public function __construct(Vehicle $vehicle, Photo $photo, ?PhotoStatus $status = null, string $verb = 'GET')
    {
        $this->verb = strtoupper($verb);
        $this->vehicle = $vehicle;
        $this->status = $status;
        $this->photo = $photo;
    }

    /**
     * Get a property of the request or null if it has not been set
     *
     * @param string $property The property to try and get
     *
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
     *
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
     *
     * @param Response $response THe response from the request
     *
     */
    public function process(Response $response): mixed
    {
        $status = $this->photo->status(new Headers($response), $this->vehicle);
        if ($status->isOutdated()) {
            return $status;
        }
    }

    /**
     * Calling this method will set the request verb. How that is implemented
     * is up to the developer
     *
     * @param string $verb The verb to set
     *
     */
    public function verb(string $verb): void
    {
        $this->verb = $verb;
    }
}
