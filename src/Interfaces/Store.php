<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Store
 * @property string|int $id
 */
interface Store
{
    /**
     * Get the primary identifier for the store
     * @return string|int
     */
    public function identifier();

    /**
     * Get the name of the store
     * @return string
     */
    public function name(): string;

    /**
     * Get a custom property
     *
     * @param string $property The property
     * @param mixed  $default  The property default
     *
     * @return mixed
     */
    public function property(string $property, $default = null);

    /**
     * Convert the store into an array of data
     *
     * @return mixed
     */
    public function toArray();
}
