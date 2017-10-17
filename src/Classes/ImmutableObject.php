<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Exception;
use Illuminate\Contracts\Validation\Factory;
use JsonSerializable;
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
     */
    public function __construct($original = [], ?Factory $validator = null)
    {
        if (!is_array($original)) {
            $original = json_decode(json_encode($original), true);
        }

        $this->attributes = $original;
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
     * Get the last validation message
     *
     * @throws Exception
     *
     * @return null|string
     */
    public function getValidationMessage(): ?string
    {
        if (!$this->validator) {
            $class = Factory::class;
            throw new Exception(
                'Cannot use getValidationMessage without passing a '.$class.' to the constructor'
            );
        }

        return $this->errors;
    }

    /**
     * Is the object valid?
     *
     * @throws Exception
     *
     * @return bool
     */
    public function isValid(): bool
    {
        if (!$this->validator) {
            $class = Factory::class;
            throw new Exception(
                'Cannot use isValid without passing a '.$class.' to the constructor'
            );
        }

        $validator = $this->validator->make($this->attributes, $this->rules);
        $result = !$validator->fails();
        $this->errors = $validator->errors()->all();
        return $result;
    }

    /**
     * Implement jsonSerialize
     *
     * @return mixed[]
     */
    public function jsonSerialize(): array
    {
        return $this->attributes;
    }
}
