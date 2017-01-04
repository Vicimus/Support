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
}
