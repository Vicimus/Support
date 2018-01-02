<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * Class SingleDownload
 */
class SingleDownload implements DownloadRequest
{
    /**
     * The photo
     *
     * @var Photo
     */
    protected $photo;

    /**
     * The vehicle
     *
     * @var Vehicle
     */
    protected $vehicle;

    /**
     * SingleDownload constructor.
     *
     * @param Vehicle     $vehicle The vehicle
     * @param PhotoStatus $photo   The photo status
     */
    public function __construct(Vehicle $vehicle, PhotoStatus $photo)
    {
        $this->vehicle = $vehicle;
        $this->photo = $photo;
    }

    /**
     * Get the async request pool
     *
     * @throws DownloadException
     *
     * @return AsyncRequestPool
     */
    public function getAsyncPool(): AsyncRequestPool
    {
        throw new DownloadException('Cannot request async pool from ' . get_class($this));
    }

    /**
     * Get the single photo status
     *
     * @return PhotoStatus
     */
    public function getSinglePhotoStatus(): PhotoStatus
    {
        return $this->photo;
    }

    /**
     * Get the single download vehicle unit
     *
     * @return Vehicle
     */
    public function getSingleVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    /**
     * Is your download request an async request or a single download
     *
     * @return bool
     */
    public function isAsynchronous(): bool
    {
        return false;
    }
}
