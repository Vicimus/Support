<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Property
 */
interface Property
{
    /**
     * Get the display string for the input
     */
    public function display(): string;

    /**
     * Get the input type for the property
     */
    public function input(): string;

    /**
     * Get the name of the property
     *
     */
    public function property(): ?string;

    /**
     * Retrieves a validation rules string
     *
     * ie. string|max:40|nullable
     *
     */
    public function restrictions(): ?string;

    /**
     * The datatype expected for the property
     */
    public function type(): string;

    /**
     * Get the value of the property
     *
     */
    public function value(): mixed;

    /**
     * Retrieves the possible values that the property can be
     *
     * @return mixed[]
     */
    public function values(): array;
}
