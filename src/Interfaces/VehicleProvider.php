<?php

namespace Vicimus\Support\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Enforces a contract for vehicle providers within the framework
 */
interface VehicleProvider
{
    /**
     * Get a collection of vehicle instances
     *
     * @return Iterable
     */
    public function get(...$args) : Collection;
}
