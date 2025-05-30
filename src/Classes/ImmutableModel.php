<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use InvalidArgumentException;
use stdClass;
use Vicimus\Support\Database\Model;

use function is_array;

class ImmutableModel extends ImmutableObject
{
    /**
     * ImmutableModel constructor.
     * @throws InvalidArgumentException
     */
    public function __construct(
        stdClass | array $original = [],
        ?Model $model = null,
    ) {
        $this->merge($original, $model);

        parent::__construct($original);
    }

    /**
     * Retrieve the base model attributes
     *
     * This method is to be overwritten by each extended class making available the attributes to merge with a payload
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]|mixed[][]
     */
    protected function attributes(): array
    {
        return [];
    }

    /**
     * Merge the payload with defaults from the provided model
     */
    protected function merge(mixed &$payload, ?Model $model): void
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
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param string  $attribute The attribute to check
     * @param mixed[] $payload   The provided payload
     * @param Model   $model     The model providing a fallback value
     */
    private function check(string $attribute, array &$payload, Model $model): void
    {
        if (array_key_exists($attribute, $payload)) {
            return;
        }

        $payload[$attribute] = $model->$attribute;
    }
}
