<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Interfaces\Property;

/**
 * Interface PropertyProvider
 */
interface PropertyProvider
{
    /**
     * Retrieve the associated items
     * @return string[]
     */
    public function items(): array;

    /**
     * Retrieve a list of properties which are shared across items
     *
     * @return Property[]
     */
    public function properties(): array;
}
