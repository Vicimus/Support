<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Properties;

use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\Property;
use Vicimus\Support\Interfaces\PropertyRecord;

/**
 * Finds properties in an instance
 */
class Finder
{
    /**
     * Find the provided property from the source
     *
     * @param PropertyProvider $provider The property provider
     * @param PropertyRecord   $property Property to search for
     *
     * @return Property|null
     *
     * @todo
     * - Does this need access to the asset owning the property to see if its a part of the grouping
     * - Should a source provide multiple groupings
     */
    protected function find(PropertyProvider $provider, PropertyRecord $property): ?Property
    {
        /** @var Property $prop */
        foreach ($provider->properties() as $prop) {
            if ($prop->property !== $property->name()) {
                continue;
            }

            return $prop;
        }

        return null;
    }
}
