<?php declare(strict_types = 1);

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
class ImmutableObject implements ArrayAccess, JsonSerializable, WillValidate
{
    /**
     * The read-only properties
     *
     * @var mixed[][]
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

    private $hasBeenCast = [];

    /**
     * ImmutableObject constructor.
     *
     * @param mixed   $original  The original attributes
     * @param Factory $validator The validator factory
     *
     * @throws InvalidArgumentException
     */
    public function __construct($original = [], ?Factory $validator = null)
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

        $this->attributes = $original ?? [];
        $this->validator = $validator;
    }

    /**
     * Read an attribute
     *
     * @param string $property The property to get
     *
     * @return mixed
     */
    public function __get(string $property)
    {
        return $this->doAttributeCast($property);
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
    public function __set(string $property, $value): void
    {
        throw new RuntimeException('Cannot set the value of an ImmutableObject');
    }

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString(): string
    {
        return (string) json_encode($this->jsonSerialize());
    }

    /**
     * Get the last validation message
     *
     * @throws ImmutableObjectException
     *
     * @return null|string
     */
    public function getValidationMessage(): ?string
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
    public function isValid(?Factory $validator = null): bool
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
    public function jsonSerialize(): array
    {
        return $this->toArray();
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
     * @return bool true on success or false on failure.
     * </p>
     * <p>
     * The return value will be casted to boolean if non-boolean was returned.
     * @since 5.0.0
     */
    public function offsetExists($offset): bool
    {
        return array_key_exists($offset, $this->attributes);
    }

    /**
     * Get an attribute by offset
     *
     * @param mixed $offset The offset
     *
     * @return array|mixed|mixed[]|null
     */
    public function offsetGet($offset)
    {
        return $this->doAttributeCast($offset);
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
    public function offsetSet($offset, $value): void
    {
        $this->$offset = $value;
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
    public function offsetUnset($offset): void
    {
        unset($this->attributes[$offset]);
    }

    /**
     * Get the array representation
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        $payload = [];
        foreach (array_filter($this->attributes, function ($key) {
            return !in_array($key, $this->hidden, false);
        }, ARRAY_FILTER_USE_KEY) as $property => $item) {
            $payload[$property] = $this->convertArrayItem($item, $property);
        }

        return $payload;
    }

    /**
     * Cast a value
     *
     * @param string|int $property The property
     * @param string|int $value    The value to cast
     *
     * @return array|mixed
     */
    private function cast($property, $value)
    {
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
     * Convert a single item
     *
     * @param ImmutableObject|mixed[]|mixed $item     The item
     * @param string|int                    $property The property we are dealing with
     *
     * @return mixed|mixed[]
     */
    private function convertArrayItem($item, $property)
    {
        if ($item instanceof self) {
            return $item->toArray();
        }

        if (!is_array($item)) {
            return $this->doAttributeCast($property, $item);
        }

        return $this->convertToArray($item);
    }

    /**
     * Convert recursively to an array
     *
     * @param mixed[] $items The items to convert
     *
     * @return mixed[]
     */
    private function convertToArray(array $items): array
    {
        $payload = [];
        foreach ($items as $property => $item) {
            $payload[$property] = $this->convertArrayItem($item, $property);
        }

        return $payload;
    }

    /**
     * Cast a specific value
     *
     * @param string|int $property      The property being cast
     * @param string|int $existingValue The existing value to use
     *
     * @return mixed
     */
    private function doAttributeCast($property, $existingValue = null)
    {
        if (array_key_exists($property, $this->hasBeenCast)) {
            return $existingValue ?? $this->attributes[$property] ?? null;
        }

        $this->hasBeenCast[$property] = true;
        $value = $existingValue ?? $this->attributes[$property] ?? null;

        if ($value === null) {
            return null;
        }

        if (!array_key_exists($property, $this->casts)) {
            return $value;
        }

        $value = $this->cast($property, $value);
        $this->attributes[$property] = $value;
        return $value;
    }

    /**
     * Check if a value is both an array and likely just a numeric array,
     * as opposed to an object structure converted into an array
     *
     * @param mixed $value The value to inspect
     *
     * @return bool
     */
    private function isNumericArray($value): bool
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
    private function isScalar(string $value): bool
    {
        return in_array($value, [
            'int', 'bool', 'string', 'float',
        ]);
    }
}
