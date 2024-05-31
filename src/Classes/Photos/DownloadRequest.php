<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * Interface DownloadRequest
 */
interface DownloadRequest
{
    /**
     * Get the async request pool
     *
     */
    public function getAsyncPool(): AsyncRequestPool;

    /**
     * Get the single photo status
     *
     */
    public function getSinglePhotoStatus(): PhotoStatus;

    /**
     * Get the single download vehicle unit
     *
     */
    public function getSingleVehicle(): Vehicle;

    /**
     * Is your download request an async request or a single download
     *
     */
    public function isAsynchronous(): bool;
}
