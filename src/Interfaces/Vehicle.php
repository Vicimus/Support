<?php

namespace Vicimus\Support\Interfaces;

/**
 * Enforces common methods among vehicle classes
 */
interface Vehicle
{
    /**
     * Return an array of properties that can be used to represent the
     * vehicle
     *
     * @return array
     */
    public function toArray();

    /**
     * Return a modified price after incentives have been applied
     *
     * @return int
     */
    public function showPrice();

    /**
     * Get the description of the type of vehicle (new, used, showroom, banana)
     *
     * @return string
     */
    public function getType();
}
