<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use InvalidArgumentException;
use Vicimus\Support\Database\Model;
use function is_array;

/**
 * Class ImmutableObject
 */
class ImmutableModel extends ImmutableObject
{
    /**
     * ImmutableModel constructor.
     *
     * @param mixed $original The original attributes
     * @param Model $model    Optionally a model to provide default values
     *
     * @throws InvalidArgumentException
     */
    public function __construct($original = [], ?Model $model = null)
    {
        $this->merge($original, $model);

        parent::__construct($original);
    }

    /**
     * Retrieve the base model attributes
     *
     * This method is to be overwritten by each extended class making available the attributes to merge with a payload
     *
     * @return string[]
     */
    protected function attributes(): array
    {
        return [];
    }

    /**
     * Merge the payload with defaults from the provided model
     *
     * @param mixed $payload The payload provided to manipulate
     * @param Model $model   The model to merge with
     *
     * @return void
     */
    protected function merge(&$payload, ?Model $model): void
    {
        if (!$model) {
            return;
        }

        if (!is_array($payload)) {
            $payload = (array) $payload;
        }

        foreach ($this->attributes() as $attribute) {
            $this->check($attribute, $payload, $model);
        }
    }

    /**
     * Check the provided attribute vs the payload provided
     *
     * @param string  $attribute The attribute to check
     * @param mixed[] $payload   The provided payload
     * @param Model   $model     The model providing a fallback value
     *
     * @return void
     */
    private function check(string $attribute, array &$payload, Model $model): void
    {
        if (array_key_exists($attribute, $payload)) {
            return;
        }

        $payload[$attribute] = $model->$attribute;
    }
}
