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
     * Override set attribute
     *
     * @param string|int|bool      $key The key to set
     * @param string|int|bool|null $value The value to set it to
     *
     * @return void
     */
    public function setAttribute($key, $value);

    /**
     * Convert the store into an array of data
     *
     * @return mixed
     */
    public function toArray();
}
