<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use InvalidArgumentException;
use Vicimus\Support\Database\Model;

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
     * @param string[] $payload The payload provided to manipulate
     * @param Model    $model   The model to merge with
     *
     * @return void
     */
    protected function merge(array &$payload, ?Model $model): void
    {
        if (!$model) {
            return;
        }

        foreach ($this->attributes() as $attribute) {
            if (array_key_exists($attribute, $payload)) {
                continue;
            }

            $payload[$attribute] = $model->$attribute;
        }
    }
}
