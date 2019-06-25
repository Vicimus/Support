<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Properties;

use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\PropertyRecord;

/**
 * Provides property values
 */
class Values extends Finder
{
    /**
     * Retrieve the possible values a property can have
     *
     * @param PropertyProvider $provider Property provider
     * @param PropertyRecord   $property The property to check
     * @return mixed[]
     */
    public function values(PropertyProvider $provider, PropertyRecord $property): array
    {
        $prop = $this->find($provider, $property);
        return ($prop) ? $prop->values() : [];
    }
}
