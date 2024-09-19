<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Classes\Grouping;
use Vicimus\Support\Interfaces\Property;

interface PropertyProvider
{
    /**
     * Get the asset grouping for this data source. The main reason this
     * was created was for us to be able to handle shared properties across
     * many assets. Specifically, Facebook has many assets that all share
     * specific properties.
     */
    public function grouping(): Grouping;

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
    public function properties(?int $storeId = null): array;
}
