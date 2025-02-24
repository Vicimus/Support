<?php declare(strict_types = 1);

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
     * @return int|string|mixed|null
     */
    public function property(string $name, $default = null);

    /**
     * Check if there is a property value
     *
     * @param string $property The property to set
     * @param mixed  $value    If set, will record a property rather than get
     * @param int    $hidden   The hidden state of a property
     *
     * @return void
     */
    public function record(string $property, $value = null, int $hidden = 0): void;
}
