<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

class SingleDownload implements DownloadRequest
{
    protected PhotoStatus $photo;

    protected Vehicle $vehicle;

    public function __construct(Vehicle $vehicle, PhotoStatus $photo)
    {
        $this->vehicle = $vehicle;
        $this->photo = $photo;
    }

    /**
     * Get the async request pool
     * @throws DownloadException
     */
    public function getAsyncPool(): AsyncRequestPool
    {
        throw new DownloadException('Cannot request async pool from ' . static::class);
    }

    public function getSinglePhotoStatus(): PhotoStatus
    {
        return $this->photo;
    }

    public function getSingleVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function isAsynchronous(): bool
    {
        return false;
    }
}
