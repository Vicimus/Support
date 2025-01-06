<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Properties;

use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\Property;
use Vicimus\Support\Interfaces\PropertyRecord;

class Finder
{
    /**
     * Find the provided property from the source
     */
    protected function find(PropertyProvider $provider, PropertyRecord $property, ?int $storeId = null): ?Property
    {
        /** @var Property $prop */
        foreach ($provider->properties($storeId) as $prop) {
            if ($prop->property() !== $property->name()) {
                continue;
            }

            return $prop;
        }

        return null;
    }
}
