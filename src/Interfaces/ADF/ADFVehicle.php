<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\ADF;

/**
 * Enforces methods required to generate ADFs containing vehicle information
 */
interface ADFVehicle
{
    /**
     * Describe the vehicle
     *
     * @return string
     */
    public function describe(): string;

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
     * Retrieve the vehicle stock number
     * @return string
     */
    public function stockNumber(): string;

    /**
     * Get an array of meaningful properties about this vehicle
     *
     * @return string[]
     */
    public function toAdfArray(): array;

    /**
     * Get the vehicle trim
     *
     * @return string
     */
    public function trim(): string;

    /**
     * Should return the type of vehicle. Things like showroom, new, used, etc
     *
     * @return string
     */
    public function type(): string;

    /**
     * Retrieve the vehicle VIN
     * @return string
     */
    public function vin(): string;
}
