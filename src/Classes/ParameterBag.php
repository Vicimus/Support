<?php declare(strict_types = 1);

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

    /**
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since  5.0.0
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($this->attributes, $offset);
    }

    /**
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since  5.0.0
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since  5.0.0
     */
    public function offsetSet($offset, $value): void
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since  5.0.0
     */
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }
}
