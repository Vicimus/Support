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
//    public function toArray();

    /**
     * Get an Unhaggle/Chrome styleid representing the vehicle. If the styleid
     * is unknown or unavailable, return null.
     *
     * @return ?int
     */
//    public function styleid() : ?int;

    /**
     * Get the primary key of this vehicle instance. Of course, if the model
     * has not yet been saved, it's id will be null so you can return null
     * from this method but it may cause issues so it's not recommended;
     *
     * @return ?int
     */
//    public function id() : ?int;

    /**
     * Describe the type of vehicle this is (a new vehicle, used vehicle,
     * showroom vehicle, etc).
     *
     * @return string
     */
//    public function type() : string;

    /**
     * Return a string that will describe the vehicle in a sensible way
     *
     * @return string
     */
//    public function __toString() : string;
}
