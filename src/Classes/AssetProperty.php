<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\Property;
use Vicimus\Support\Interfaces\PropertyRecord;

use function is_string;

/**
 * @property int $id
 * @property string $display
 * @property string $input
 * @property string $property
 * @property string $value
 * @property string $restrictions
 * @property string $type
 * @property string[] $values
 * @property bool $complexValues
 */
class AssetProperty extends ImmutableObject implements Property
{
    /**
     * Properties hidden from toArray
     * @var string[]
     */
    protected array $hidden = [
        'created_at', 'updated_at',
    ];

    /**
     * AssetProperty constructor.
     *
     * @param string[]|object $data Property data
     */
    public function __construct(array|object $data)
    {
        parent::__construct($data);

        $this->defaults();
        if (is_string($this->values)) {
            $this->attributes['values'] = json_decode($this->values, true);
        }

        $this->set('values', $this->parseValues());
    }

    /**
     * Retrieve the input type for the property
     */
    public function display(): string
    {
        return $this->display;
    }

    /**
     * Retrieve the input type for the property
     */
    public function input(): string
    {
        return $this->input;
    }

    /**
     * Populate an asset property with data from the provided model
     *
     * @param PropertyRecord $property  Asset property record representing a database model
     * @param bool           $saveValue Should we save the value or just always set it to be blank
     * @param string|null    $fallback  A value to fallback to
     *
     */
    public function populate(PropertyRecord $property, bool $saveValue = true, ?string $fallback = ''): void
    {
        $value = '';
        if ($saveValue) {
            $value = $property->getValue() ?? '';
        }

        if (!$value && $fallback) {
            $value = $fallback;
        }

        $this->set('value', $value);
        $this->set('id', $property->getId());
    }

    /**
     * Retrieve the property slug for the property
     */
    public function property(): string
    {
        return $this->property;
    }

    /**
     * Retrieve the validation string for the property
     */
    public function restrictions(): string
    {
        return $this->restrictions;
    }

    /**
     * The payload to create from
     *
     * @return string[]
     */
    public function toPayload(): array
    {
        return [
            'display' => $this->display,
            'input' => $this->input,
            'property' => $this->property,
            'value' => $this->value,
        ];
    }

    /**
     * The datatype of the item
     *
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * Retrieve the value of the property
     *
     * @return string|int|bool
     */
    public function value(): mixed
    {
        return $this->attributes['value'];
    }

    /**
     * Retrieve and/or set the possible values for the property
     *
     * @param string[] $values The values to set
     *
     * @return string[]
     */
    public function values(?array $values = null): array
    {
        if ($values !== null) {
            $this->set('values', $values);
        }

        return $this->attributes['values'];
    }

    /**
     * Set default property values
     */
    private function defaults(): void
    {
        if ($this->datatype) {
            $this->set('type', $this->datatype);
        }

        $defaults = ['input' => 'text', 'type' => 'string', 'restrictions' => '', 'values' => []];
        foreach ($defaults as $property => $default) {
            if ($this->$property) {
                continue;
            }

            $this->set($property, $default);
        }
    }

    /**
     * Generate a key
     *
     * @param string $value The value to base the key from
     *
     */
    private function generateKey(string $value): string
    {
        return strtolower(str_replace(' ', '_', $value));
    }

    /**
     * Parse values out and any with numeric indexes can be converted
     * @return string[]
     */
    private function parseStandardValues(): array
    {
        $payload = [];
        foreach ($this->values as $index => $value) {
            if (is_string($index)) {
                $payload[$index] = $value;
                continue;
            }

            $key = $this->generateKey((string) $value);
            $payload[$key] = $value;
        }

        return $payload;
    }

    /**
     * Parse values out and check for no values/complex values
     *
     * @return string[]|ComplexValue[]
     */
    private function parseValues(): array
    {
        if (!count($this->values)) {
            return [];
        }

        if ($this->values[array_key_first($this->values)] instanceof ComplexValue) {
            return $this->values;
        }

        return $this->parseStandardValues();
    }

    /**
     * Set an attribute value
     *
     * @param string                                $property The property to set
     * @param string[]|int[]|bool[]|string|int|bool $value    The value to use
     *
     */
    private function set(string $property, mixed $value): void
    {
        $this->attributes[$property] = $value;
    }
}
