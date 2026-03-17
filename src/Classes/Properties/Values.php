<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Properties;

use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\PropertyRecord;

class Values extends Finder
{
    /**
     * Retrieve the possible values a property can have
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[]
     */
    public function values(PropertyProvider $provider, PropertyRecord $property, ?int $storeId = null): array
    {
        $prop = $this->find($provider, $property, $storeId);
        return ($prop) ? $prop->values() : [];
    }
}
