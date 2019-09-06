<?php

namespace Vicimus\Support\Classes;

use ArrayAccess;
use Illuminate\Contracts\Validation\Factory;
use InvalidArgumentException;
use JsonSerializable;
use RuntimeException;
use Vicimus\Support\Exceptions\ImmutableObjectException;
use Vicimus\Support\Interfaces\WillValidate;

/**
 * Class ImmutableObject
 */
class ImmutableObject implements JsonSerializable, WillValidate, ArrayAccess
{
    /**
     * The read-only properties
     *
     * @var string[]
     */
    protected $attributes = [];

    /**
     * Any properties to convert into other types
     *
     * @var string[]
     */
    protected $casts = [];

    /**
     * Properties to hide from json encoding and toArray calls
     *
     * @var string[]
     */
    protected $hidden = [];

    /**
     * Validation rules
     *
     * @var string[]
     */
    protected $rules = [];

    /**
     * Holds a validator factory
     *
     * @var Factory|null
     */
    protected $validator;

    /**
     * The last error messages
     *
     * @var string
     */
    private $errors;

    /**
     * ImmutableObject constructor.
     *
     * @param mixed   $original  The original attributes
     * @param Factory $validator The validator factory
     *
     * @throws InvalidArgumentException
     */
    public function __construct($original = [], Factory $validator = null)
    {
        if (!is_array($original) && !is_object($original)) {
            $type = gettype($original);
            throw new InvalidArgumentException(sprintf(
                'First parameter must be array or object, %s given with value `%s`',
                $type,
                var_export($original, true)
            ));
        }

        if (!is_array($original)) {
            $original = json_decode(json_encode($original), true);
        }

        $this->attributes = $this->castAttributes($original ? $original : []);
        $this->validator = $validator;
    }

    /**
     * Read an attribute
     *
     * @param string $property The property to get
     *
     * @return mixed
     */
    public function __get($property)
    {
        return isset($this->attributes[$property]) ? $this->attributes[$property] : null;
    }

    /**
     * Handle set
     *
     * @param string $property The property to set
     * @param mixed  $value    The value to set it to
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function __set($property, $value)
    {
        throw new RuntimeException('Cannot set the value of an ImmutableObject');
    }

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->jsonSerialize());
    }

    /**
     * Get the last validation message
     *
     * @throws ImmutableObjectException
     *
     * @return null|string
     */
    public function getValidationMessage()
    {
        if (!$this->validator) {
            $class = Factory::class;
            throw new ImmutableObjectException(
                'Cannot use getValidationMessage without passing a '.$class.' to the constructor'
            );
        }

        return $this->errors;
    }

    /**
     * Is the object valid?
     *
     * @param Factory|null $validator A validator factory
     *
     * @return bool
     * @throws ImmutableObjectException
     */
    public function isValid(Factory $validator = null)
    {
        if (!$this->validator && $validator) {
            $this->validator = $validator;
        }

        if (!$this->validator) {
            $class = Factory::class;
            throw new ImmutableObjectException(
                'Cannot use isValid without passing a '.$class.' to the constructor'
            );
        }

        $validator = $this->validator->make($this->attributes, $this->rules);
        $result = !$validator->fails();
        $this->errors = implode(' ', $validator->errors()->all());
        return $result;
    }

    /**
     * Implement jsonSerialize
     *
     * @return mixed[]
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Get the array representation
     *
     * @return mixed[]
     */
    public function toArray()
    {
        if (!count($this->hidden)) {
            return $this->attributes;
        }

        return array_filter($this->attributes, function ($key) {
            return !in_array($key, $this->hidden);
        }, ARRAY_FILTER_USE_KEY);
    }

    /**
     * Takes in the original data and converts it according to the protected
     * local property $this->casts
     *
     * @param mixed[] $attributes The attributes to transform
     *
     * @return mixed[]
     */
    private function castAttributes(array $attributes)
    {
        if (!count($this->casts)) {
            return $attributes;
        }

        $transformed = [];
        foreach ($attributes as $property => $value) {
            $transformed[$property] = $this->doAttributeCast($property, $value);
        }

        return $transformed;
    }

    /**
     * Cast a specific value
     *
     * @param string|int $property The property being cast
     * @param mixed      $value    The current value
     *
     * @return mixed
     */
    private function doAttributeCast($property, $value)
    {
        if ($value === null) {
            return $value;
        }

        if (!array_key_exists($property, $this->casts)) {
            return $value;
        }

        $arrayMode = $this->isNumericArray($value);
        if (!$arrayMode) {
            $value = [$value];
        }

        $transformed = [];
        foreach ($value as $individual) {
            $transform = $this->casts[$property];
            if ($this->isScalar($transform)) {
                settype($individual, $transform);
                $transformed[] = $individual;
                continue;
            }

            $transformed[] = new $transform($individual);
        }

        if (!$arrayMode) {
            return $transformed[0];
        }

        return $transformed;
    }

    /**
     * Check if a value is both an array and likely just a numeric array,
     * as opposed to an object structure converted into an array
     *
     * @param mixed $value The value to inspect
     *
     * @return bool
     */
    private function isNumericArray($value)
    {
        if (!is_array($value)) {
            return false;
        }

        $keys = array_keys($value);
        if (!count($keys)) {
            return true;
        }

        $last = count($value) - 1;
        return $keys[0] === 0 && $keys[$last] === $last;
    }

    /**
     * Check if a type is scalar or not
     *
     * @param string $value The value to inspect
     *
     * @return bool
     */
    private function isScalar($value)
    {
        return in_array($value, [
            'int', 'bool', 'string', 'float',
        ]);
    }

    /**
     * Whether a offset exists
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetexists.php
     *
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     *
     * @return boolean true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset)
    {
        return isset($this->attributes[$offset]);
    }

    /**
     * Offset to retrieve
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     *
     * @return mixed Can return all value types.
     * @since 5.0.0
     */
    public function offsetGet($offset)
    {
        return isset($this->attributes[$offset]) ? $this->attributes[$offset] : null;
    }

    /**
     * Offset to set
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetset.php
     *
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetSet($offset, $value)
    {
        $this->attributes[$offset] = $value;
    }

    /**
     * Offset to unset
     *
     * @link  https://php.net/manual/en/arrayaccess.offsetunset.php
     *
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     *
     * @return void
     * @since 5.0.0
     */
    public function offsetUnset($offset){
        unset($this->attributes[$offset]);
    }
}
