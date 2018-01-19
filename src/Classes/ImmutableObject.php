<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Illuminate\Contracts\Validation\Factory;
use InvalidArgumentException;
use JsonSerializable;
use Vicimus\Support\Exceptions\ImmutableObjectException;
use Vicimus\Support\Interfaces\WillValidate;

/**
 * Class ImmutableObject
 *
 * @package Vicimus\Support\Classes
 */
class ImmutableObject implements JsonSerializable, WillValidate
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
    public function __construct($original = [], ?Factory $validator = null)
    {
        if (!is_array($original) && !is_object($original)) {
            $type = gettype($original);
            throw new InvalidArgumentException(
                'First parameter must be array or object, '.$type.' given'
            );
        }
        if (!is_array($original)) {
            $original = json_decode(json_encode($original), true);
        }

        $this->attributes = $this->castAttributes($original ?? []);
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
        return $this->attributes[$property] ?? null;
    }

    /**
     * Convert to a string
     *
     * @return string
     */
    public function __toString(): string
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
     * @throws ImmutableObjectException
     *
     * @return bool
     */
    public function isValid(): bool
    {
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
     * Get the array representation
     *
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * Takes in the original data and converts it according to the proptected
     * local property $this->casts
     *
     * @param mixed[] $attributes The attributes to transform
     *
     * @return mixed[]
     */
    private function castAttributes(array $attributes): array
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
     * @param string $property The property being cast
     * @param mixed  $value    The current value
     *
     * @return mixed
     */
    private function doAttributeCast(string $property, $value)
    {
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
            if ($this->isScaler($transform)) {
                $transformed[] = settype($individual, $transform);
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
     * Check if a value is both an array and likely just a numberic array,
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
    private function isScaler(string $value): bool
    {
        return in_array($value, [
            'int', 'bool', 'string', 'float',
        ]);
    }
}
