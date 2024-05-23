<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use ArrayAccess;

/**
 * Class ParameterBag
 */
class ParameterBag extends ImmutableObject implements ArrayAccess
{
    /**
     * Checksum of the value of the parameters
     *
     */
    public function checksum(): string
    {
        return md5(json_encode($this->toArray()));
    }

    /**
     * Get a parameter value
     *
     * @param string $property The property to get
     * @param mixed  $default  A default to use if nothing is found
     *
     */
    public function get(string $property, mixed $default = null): mixed
    {
        return $this->attributes[$property] ?? $default;
    }

    /**
     * Get and then unset the value
     *
     * @param string $property The property to get and unset
     * @param mixed  $default  The default to use if nothing is found
     *
     */
    public function grab(string $property, mixed $default = null): mixed
    {
        $value = $this->get($property, $default);
        unset($this->attributes[$property]);
        return $value;
    }

    /**
     * Check if the bag contains a property
     *
     * @param string $property The property to check existence of
     *
     */
    public function has(string $property): bool
    {
        return array_key_exists($property, $this->attributes);
    }

    /**
     * Offset to set
     *
     * @param mixed $offset The offset to set
     * @param mixed $value  The value to set it to
     *
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Put a new value in the bag
     *
     * @param string $property The property to add
     * @param mixed  $value    The value to add
     *
     */
    public function put(string $property, mixed $value): void
    {
        $this->attributes[$property] = $value;
    }

    /**
     * Rename an attribute
     *
     * @param string $original The original column
     * @param string $updated  The new column
     *
     */
    public function rename(string $original, string $updated): void
    {
        $this->attributes[$updated] = $this->attributes[$original] ?? null;
        unset($this->attributes[$original]);
    }
}
