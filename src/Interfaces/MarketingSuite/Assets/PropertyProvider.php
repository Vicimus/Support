<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Classes\Grouping;
use Vicimus\Support\Interfaces\PropertyRecord;

/**
 * Interface PropertyProvider
 */
interface PropertyProvider
{
    /**
     * Retrieve the associated items
     * @return array
     */
    public function items(): array;
    
    /**
     * Retrieve a list of properties which are shared across items
     *
     * @return AssetProperty[]
     */
    public function properties(): array;
}
