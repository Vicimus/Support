<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Relation;
use Shared\Models\Audiences\Property;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * Interface HasProperties
 *
 * @property Property[] $properties
 */
interface HasProperties extends Eloquent, HasDatatype, HasHash
{
    /**
     * An audience has many properties
     *
     * @return HasMany|Property
     */
    public function properties(): Relation;
}
