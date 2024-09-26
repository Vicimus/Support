<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

class ParameterBag extends ImmutableObject
{
    /**
     * Checksum of the value of the parameters
     */
    public function checksum(): string
    {
        return md5(json_encode($this->toArray()));
    }

    public function get(string $property, mixed $default = null): mixed
    {
        return $this->attributes[$property] ?? $default;
    }

    /**
     * Get and then unset the value
     */
    public function grab(string $property, mixed $default = null): mixed
    {
        $value = $this->get($property, $default);
        unset($this->attributes[$property]);
        return $value;
    }

    /**
     * Check if the bag contains a property
     */
    public function has(string $property): bool
    {
        return array_key_exists($property, $this->attributes);
    }

    /**
     * Whether a offset exists
     */
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * Offset to set
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Offset to unset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Put a new value in the bag
     */
    public function put(string $property, mixed $value): void
    {
        $this->attributes[$property] = $value;
    }

    /**
     * Rename an attribute
     */
    public function rename(string $original, string $updated): void
    {
        $this->attributes[$updated] = $this->attributes[$original] ?? null;
        unset($this->attributes[$original]);
    }
}
