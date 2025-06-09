<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\ADF;

/**
 * Enforces methods required to generate ADFs containing vehicle information
 */
interface ADFVehicle
{
    /**
     * Describe the vehicle
     */
    public function describe(): string;

    /**
     * Returns the exterior color of the vehicle
     */
    public function exterior(): string;

    /**
     * Returns the interior color of the vehicle
     */
    public function interior(): string;

    public function make(): string;

    public function model(): string;

    /**
     * Get the number of kilometres on the odometer
     */
    public function odometer(): int;

    /**
     * Get the price of the vehicle
     */
    public function price(): int;

    /**
     * Retrieve the vehicle stock number
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
     */
    public function trim(): string;

    /**
     * Should return the type of vehicle. Things like showroom, new, used, etc
     */
    public function type(): string;

    /**
     * Retrieve the vehicle VIN
     */
    public function vin(): string;

    public function year(): string;
}
