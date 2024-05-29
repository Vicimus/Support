<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use ArrayAccess;
use Illuminate\Contracts\Validation\Factory;
use InvalidArgumentException;
use JsonSerializable;
use RuntimeException;
use Vicimus\Support\Exceptions\ImmutableObjectException;
use Vicimus\Support\Interfaces\WillValidate;
use Vicimus\Support\Traits\AttributeArrayAccess;
use Vicimus\Support\Traits\CastsAttributes;

/**
 * Class ImmutableObject
 */
class ImmutableObject implements ArrayAccess, JsonSerializable, WillValidate
{
    use AttributeArrayAccess;
    use CastsAttributes;

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
            $payload[$property] = $this->convertArrayItem($item);
        }

        return $payload;
    }

    /**
     * Takes in the original data and converts it according to the protected
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
     * Convert a single item
     *
     * @param ImmutableObject|mixed[]|mixed $item The item
     *
     * @return mixed|mixed[]
     */
    private function convertArrayItem($item)
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
}
