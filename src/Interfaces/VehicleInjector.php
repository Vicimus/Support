<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Interfaces\ADF\ADFVehicle;

/**
 * Offers vehicle injection for ADF purposes
 */
interface VehicleInjector
{
    /**
     * Look at an array of input and return an ADFVehicle or null
     *
     * @param string[] $input The input to inspect
     */
    public function vehicle(array $input): ?ADFVehicle;
}
