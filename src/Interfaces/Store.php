<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Store
 * @property string|int $id
 * @property string|null $url
 * @property string $name
 */
interface Store
{
    /**
     * Get the primary identifier for the store
     */
    public function identifier(): string | int;

    /**
     * Get the name of the store
     */
    public function name(): string;

    /**
     * Get a custom property
     */
    public function property(string $property, mixed $default = null): mixed;

    /**
     * Override set attribute
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingNativeTypeHint
     *
     * @param string|mixed $key
     * @param string|mixed $value
     */
    public function setAttribute($key, $value): void;

    /**
     * Convert the store into an array of data
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint.MissingNativeTypeHint
     */
    public function toArray();
}
