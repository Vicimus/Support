<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

class SingleDownload implements DownloadRequest
{
    public function __construct(
        protected Vehicle $vehicle,
        protected PhotoStatus $photo
    ) {
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
