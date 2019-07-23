<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Shared\Models\Audiences\Property;

/**
 * Interface HasProperties
 *
 * @property Property[] $properties
 */
interface HasProperties
{
    /**
     * An audience has many properties
     *
     * @return HasMany|Property
     */
    public function properties(): HasMany;
}
