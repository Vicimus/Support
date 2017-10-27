<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Enforces common methods among vehicle classes
 */
interface Vehicle
{
    /**
     * Return a string that will describe the vehicle in a sensible way
     *
     * @return string
     */
    public function __toString(): string;

    /**
     * Get the primary key of this vehicle instance. Of course, if the model
     * has not yet been saved, it's id will be null so you can return null
     * from this method but it may cause issues so it's not recommended;
     *
     * @return ?int
     */
    public function id(): ?int;

    /**
     * Get an Unhaggle/Chrome styleid representing the vehicle. If the styleid
     * is unknown or unavailable, return null.
     *
     * @return ?int
     */
    public function styleid(): ?int;

    /**
     * Return an array of properties that can be used to represent the
     * vehicle
     *
     * @return string[]
     */
    public function toArray(): array;

    /**
     * Describe the type of vehicle this is (a new vehicle, used vehicle,
     * showroom vehicle, etc).
     *
     * @return string
     */
    public function type(): string;
}
