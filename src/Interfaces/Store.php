<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Store
 * @property string|int $id
 * @property string|null $url
 * @property string $name
 */
interface Store
{
    /**
     * Get the primary identifier for the store
     */
    public function identifier(): string|int;

    /**
     * Get the name of the store
     */
    public function name(): string;

    /**
     * Get a custom property
     *
     * @param string $property The property
     * @param mixed  $default  The property default
     *
     */
    public function property(string $property, mixed $default = null): mixed;

    /**
     * Override set attribute
     *
     * @param string|int|bool      $key   The key to set
     * @param string|int|bool|null $value The value to set it to
     *
     */
    public function setAttribute(string|int|bool $key, string|int|bool|null $value): void;

    /**
     * Convert the store into an array of data
     *
     */
    public function toArray(): mixed;
}
