<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\Vehicle;

interface DownloadRequest
{
    public function getAsyncPool(): AsyncRequestPool;

    public function getSinglePhotoStatus(): PhotoStatus;

    public function getSingleVehicle(): Vehicle;

    public function isAsynchronous(): bool;
}
