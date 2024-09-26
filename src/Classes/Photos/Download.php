<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Interfaces\Vehicle;

/**
 * @property Vehicle $stock
 * @property PhotoStatus $status
 */
class Download extends ImmutableObject implements Downloadable
{
    public function __construct(Vehicle $vehicle, PhotoStatus $status)
    {
        parent::__construct([
            'vehicle' => $vehicle,
            'status' => $status,
        ]);
    }

    public function status(): PhotoStatus
    {
        return $this->attributes['status'];
    }

    public function vehicle(): Vehicle
    {
        return $this->attributes['vehicle'];
    }
}
