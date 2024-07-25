<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * @property string $model
 */
interface Vehicle
{
    /**
     * Get the description of the type of vehicle (new, used, showroom, banana)
     */
    public function getType(): string;

    /**
     * Return a modified price after incentives have been applied
     */
    public function showPrice(): int;

    /**
     * Return an array of properties that can be used to represent the
     * vehicle
     *
     * @return string[]|array
     */
    public function toArray(): array;
}
