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
    
    /**
     * Validates a property
     *
     * @property PropertyRecord $property The proeprty to validate
     * @property mixed          $value    The value to validate
     *
     * @return void
     */
    public function validate(PropertyRecord $property, $value): void;

    /**
     * Retrieve possible values for a property
     *
     * @param PropertyRecord $property The property to check
     * @return array
     */
    public function values(PropertyRecord $property): array;
}
