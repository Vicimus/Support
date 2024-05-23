<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\Vehicle;

/**
 * Interface Downloadable
 */
interface Downloadable
{
    /**
     * Must return a photo status object
     *
     */
    public function status(): PhotoStatus;

    /**
     * Must return the vehicle this download is associated with
     *
     */
    public function vehicle(): Vehicle;
}
