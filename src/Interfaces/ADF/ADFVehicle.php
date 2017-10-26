<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\ADF;

/**
 * Enforces methods required to generate ADFs containing vehicle information
 */
interface ADFVehicle
{
    /**
     * Returns the exterior color of the vehicle
     *
     * @return string
     */
    public function exterior(): string;

    /**
     * Returns the interior color of the vehicle
     *
     * @return string
     */
    public function interior(): string;

    /**
     * Get the number of kilometres on the odometer
     *
     * @return int
     */
    public function odometer(): int;

    /**
     * Get the price of the vehicle
     *
     * @return int
     */
    public function price(): int;

    /**
     * Get an array of meaningful properties about this vehicle
     *
     * @return string[]
     */
    public function toArray(): array;

    /**
     * Should return the type of vehicle. Things like showroom, new, used, etc
     *
     * @return string
     */
    public function type(): string;
}
