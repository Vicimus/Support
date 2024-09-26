<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Enforces a contract for vehicle providers within the framework
 */
interface VehicleProvider
{
    /**
     * Get a collection of vehicle instances
     */
    public function get(mixed ...$args): Collection;
}
