<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface SimpleProperties
 */
interface SimpleProperties
{
    /**
     * Find a property value or return null
     *
     * @param string $name    The property to look for
     * @param mixed  $default The default value to return if the property doesn't exist
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return int|string|null
     */
    public function property(string $name, mixed $default = null): mixed;

    public function record(string $property, mixed $value = null, bool $hidden = false): void;
}
