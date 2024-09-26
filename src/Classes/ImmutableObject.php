<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use ArrayAccess;
use Illuminate\Contracts\Validation\Factory;
use InvalidArgumentException;
use JsonSerializable;
use RuntimeException;
use stdClass;
use Vicimus\Support\Exceptions\ImmutableObjectException;
use Vicimus\Support\Interfaces\WillValidate;
use Vicimus\Support\Traits\AttributeArrayAccess;

/**
 * Class ImmutableObject
 */
class ImmutableObject implements ArrayAccess, JsonSerializable, WillValidate
{
    use AttributeArrayAccess;

    /**
     * The read-only properties
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @var mixed[][]
     */
    protected array $attributes = [];

    /**
     * Any properties to convert into other types
     * @var string[]
     */
    protected array $casts = [];

    /**
     * Properties to hide from json encoding and toArray calls
     * @var string[]
     */
    protected array $hidden = [];

    /**
     * Validation rules
     * @var string[]
     */
    protected array $rules = [];

    /**
     * Holds a validator factory
     */
    protected ?Factory $validator;

    /**
     * The last error messages
     */
    private string $errors;

    /**
     * @throws InvalidArgumentException
     */
    public function __construct(stdClass | array $original = [], ?Factory $validator = null)
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

        $this->attributes = $this->castAttributes($original ?? []);
        $this->validator = $validator;
    }

    /**
     * Read an attribute
     */
    public function __get(string $property): mixed
    {
        return $this->attributes[$property] ?? null;
    }

    /**
     * @throws RuntimeException
     */
    public function __set(string $property, mixed $value): void
    {
        throw new RuntimeException('Cannot set the value of an ImmutableObject');
    }

    /**
     * Convert to a string
     */
    public function __toString(): string
    {
        return (string) json_encode($this->jsonSerialize());
    }

    /**
     * Get the last validation message
     *
     * @throws ImmutableObjectException
     */
    public function getValidationMessage(): ?string
    {
        if (!$this->validator) {
            $class = Factory::class;
            throw new ImmutableObjectException(
                'Cannot use getValidationMessage without passing a ' . $class . ' to the constructor',
            );
        }

        return $this->errors;
    }

    /**
     * Is the object valid?
     * @throws ImmutableObjectException
     */
    public function isValid(?Factory $factory = null): bool
    {
        if (!$this->validator && $factory) {
            $this->validator = $factory;
        }

        if (!$this->validator) {
            $class = Factory::class;
            throw new ImmutableObjectException(
                'Cannot use isValid without passing a ' . $class . ' to the constructor'
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
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /**
     * Get the array representation
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]
     */
    public function toArray(): array
    {
        $payload = [];
        $filtered = array_filter(
            $this->attributes,
            fn ($key) => !in_array($key, $this->hidden, true),
            ARRAY_FILTER_USE_KEY,
        );

        foreach ($filtered as $property => $item) {
            $payload[$property] = $this->convertArrayItem($item);
        }

        return $payload;
    }

    /**
     * Takes in the original data and converts it according to the protected
     * local property $this->casts
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
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
     * Convert a single item
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param ImmutableObject|mixed[]|mixed $item The item
     */
    private function convertArrayItem(mixed $item): mixed
    {
        if ($item instanceof self) {
            return $item->toArray();
        }

        if (!is_array($item)) {
            return $item;
        }

        return $this->convertToArray($item);
    }

    /**
     * Convert recursively to an array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param mixed[] $items The items to convert
     *
     * @return mixed[]
     */
    private function convertToArray(array $items): array
    {
        $payload = [];
        foreach ($items as $property => $item) {
            $payload[$property] = $this->convertArrayItem($item);
        }

        return $payload;
    }

    /**
     * Cast a specific value
     */
    private function doAttributeCast(string | int $property, mixed $value): mixed
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
     */
    private function isNumericArray(mixed $value): bool
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
     */
    private function isScalar(string $value): bool
    {
        return in_array($value, [
            'int', 'bool', 'string', 'float',
        ], true);
    }
}
