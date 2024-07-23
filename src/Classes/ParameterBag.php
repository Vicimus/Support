<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

/**
 * Class ParameterBag
 */
class ParameterBag extends ImmutableObject
{
    /**
     * Checksum of the value of the parameters
     *
     * @return string
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
     * @return mixed
     */
    public function get(string $property, $default = null)
    {
        return $this->attributes[$property] ?? $default;
    }

    /**
     * Get and then unset the value
     *
     * @param string $property The property to get and unset
     * @param mixed  $default  The default to use if nothing is found
     *
     * @return mixed
     */
    public function grab(string $property, $default = null)
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
     * @return bool
     */
    public function has(string $property): bool
    {
        return array_key_exists($property, $this->attributes);
    }

    /**
     * Whether a offset exists
     *
     * @param mixed $offset The offset to check if it exists
     *
     * @return bool true on success or false on failure.
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * Offset to set
     *
     * @param mixed $offset The offset to set
     * @param mixed $value  The value to set it to
     *
     * @return void
     */
    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @param mixed $offset The offset to unset
     *
     * @return void
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Put a new value in the bag
     *
     * @param string $property The property to add
     * @param mixed  $value    The value to add
     *
     * @return void
     */
    public function put(string $property, $value): void
    {
        $this->attributes[$property] = $value;
    }

    /**
     * Rename an attribute
     *
     * @param string $original The original column
     * @param string $updated  The new column
     *
     * @return void
     */
    public function rename(string $original, string $updated): void
    {
        $this->attributes[$updated] = $this->attributes[$original] ?? null;
        unset($this->attributes[$original]);
    }
}
