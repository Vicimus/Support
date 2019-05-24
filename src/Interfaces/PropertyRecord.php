<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Property
 */
interface PropertyRecord
{
    /**
     * Get the value of the property
     * @return mixed
     */
    public function getValue();

    /**
     * Retrieve the name of the property
     * @return string
     */
    public function name(): string;

    /**
     * A property validates
     *
     * @property mixed $value The value to validate
     *
     * @return string
     */
    public function validate($value): void;
}
