<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * @property Headers $headers
 * @property Photo $photo
 * @property Vehicle $vehicle
 */
class PhotoStatus
{
    protected Headers $headers;

    protected Photo $photo;

    protected Vehicle $vehicle;

    /**
     * PhotoStatus constructor
     *
     * @param Photo   $photo   The stock
     * @param Headers $headers The headers from the request
     * @param Vehicle $vehicle The vehicle related to this photo
     */
    public function __construct(Photo $photo, Headers $headers, Vehicle $vehicle)
    {
        $this->headers = $headers;
        $this->photo = $photo;
        $this->vehicle = $vehicle;
    }

    /**
     * Get a protected property for read only
     */
    public function __get(string $property): mixed
    {
        return $this->$property;
    }

    /**
     * Get a download request for the photo this is about
     */
    public function download(): Downloadable
    {
        return new Download($this->vehicle, $this);
    }

    /**
     * Is the photo outdated
     */
    public function isOutdated(): bool
    {
        if (!$this->headers->get('etag')) {
            return true;
        }

        return $this->photo->etag() !== $this->headers->get('etag');
    }
}
