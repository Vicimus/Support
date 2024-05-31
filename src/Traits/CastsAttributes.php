<?php

declare(strict_types=1);

namespace Vicimus\Support\Traits;

/**
 * Trait CastsAttributes
 *
 * @property string[] $casts
 */
trait CastsAttributes
{
    /**
     * Cast a specific value
     *
     * @param string|int $property The property being cast
     * @param mixed      $value    The current value
     *
     */
    protected function doAttributeCast(string|int $property, mixed $value): mixed
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
     */
    private function isScalar(string $value): bool
    {
        return in_array($value, [
            'int', 'bool', 'string', 'float',
        ]);
    }
}
