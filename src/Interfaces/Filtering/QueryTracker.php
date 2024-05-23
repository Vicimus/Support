<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

/**
 * Interface QueryTracker
 */
interface QueryTracker
{
    /**
     * Set a value on the tracker
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to set it to
     *
     */
    public function set(string $property, mixed $value): void;
}
