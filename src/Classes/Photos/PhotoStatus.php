<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * Class PhotoStatus
 *
 * @property Headers $headers
 * @property Photo $photo
 * @property Vehicle $vehicle
 */
class PhotoStatus
{
    /**
     * The headers to determine status
     *
     * @var Headers
     */
    protected $headers;

    /**
     * The photo this status represents
     *
     * @var Photo
     */
    protected $photo;

    /**
     * The vehicle related to the photo status
     *
     * @var Vehicle
     */
    protected $vehicle;

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
     *
     * @param string $property The property to get
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->$property;
    }

    /**
     * Get a download request for the photo this is about
     *
     * @return Downloadable
     */
    public function download(): Downloadable
    {
        return new Download($this->vehicle, $this);
    }

    /**
     * Is the photo outdated
     *
     * @return bool
     */
    public function isOutdated(): bool
    {
        return $this->photo->etag() !== $this->headers->get('etag');
    }
}
