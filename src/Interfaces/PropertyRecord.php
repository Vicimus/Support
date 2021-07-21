<?php declare(strict_types = 1);

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
     * @param mixed $value The value to validate
     *
     * @return void
     */
    public function validate($value): void;
}
