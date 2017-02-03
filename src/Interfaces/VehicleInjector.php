<?php

namespace Vicimus\Support\Interfaces;

/**
 * Offers vehicle injection for ADF purposes
 */
interface VehicleInjector
{
    /**
     * Look at an array of input and return an ADFVehicle or null
     *
     * @param array $input The input to inspect
     *
     * @return ADFVehicle
     */
    public function vehicle(array $input) : ?ADF\ADFVehicle;
}
