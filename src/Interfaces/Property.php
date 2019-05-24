<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Property
 */
interface Property
{
    /**
     * Get the name of the property
     *
     * @return string
     */
    public function property(): ?string;

    /**
     * Retrieves a validation rules string
     *
     * ie. string|max:40|nullable
     *
     * @return string|null
     */
    public function restrictions(): ?string;

    /**
     * The datatype expected for the property
     * @return string
     */
    public function type(): string;

    /**
     * Get the value of the property
     *
     * @return string
     */
    public function value(): ?string;

    /**
     * Retrieves the possible values that the property can be
     *
     * @return array
     */
    public function values(): array;
}
