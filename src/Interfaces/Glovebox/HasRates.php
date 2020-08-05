<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface HasRates
 */
interface HasRates
{
    /**
     * Retrieve the rate values of all rates for this vehicle.
     *
     * @param bool $lease Get lease rates or financing rates
     *
     * @return mixed[]
     */
    public function getAllRates(bool $lease = false): array;
}
