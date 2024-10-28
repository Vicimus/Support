<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

class AsyncDownload implements DownloadRequest
{
    protected AsyncRequestPool $pool;

    public function __construct(AsyncRequestPool $pool)
    {
        $this->pool = $pool;
    }

    public function getAsyncPool(): AsyncRequestPool
    {
        return $this->pool;
    }

    /**
     * Get the single photo status
     * @throws DownloadException
     */
    public function getSinglePhotoStatus(): PhotoStatus
    {
        throw new DownloadException(
            sprintf('Cannot call %s from %s', __METHOD__, static::class)
        );
    }

    /**
     * Get the single download vehicle unit
     * @throws DownloadException
     */
    public function getSingleVehicle(): Vehicle
    {
        throw new DownloadException(
            sprintf('Cannot call %s from %s', __METHOD__, static::class)
        );
    }

    /**
     * Is your download request an async request or a single download
     */
    public function isAsynchronous(): bool
    {
        return true;
    }
}
