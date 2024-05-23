<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Property
 *
 * @property int $id
 * @property mixed $value
 */
interface PropertyRecord
{
    /**
     * Get the value of the property
     */
    public function getValue(): mixed;

    /**
     * Retrieve the name of the property
     */
    public function name(): string;

    /**
     * A property validates
     *
     * @param mixed $value The value to validate
     *
     */
    public function validate(mixed $value): void;
}
