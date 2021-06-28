<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

interface Creatable
{
    /**
     * Retrieve the slug type of the asset
     *
     * @return string
     */
    public function type(): string;

    /**
     * Retrieve a path to the rendered pdf of the asset
     *
     * @return string
     */
    public function path(): string;

    /**
     * Find a property value or return null
     *
     * @param string          $name    The property to look for
     * @param string|int|bool $default The default value to return if the property doesn't exist
     *
     * @return int|string|bool|null
     */
    public function property(string $name, $default = null): string;
}
