<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\Relation;
use Vicimus\Support\Interfaces\Eloquent;
use Vicimus\Support\Interfaces\Property;

/**
 * @property Property[] $properties
 */
interface HasProperties extends Eloquent, HasDatatype, HasHash
{
    /**
     * An audience has many properties
     */
    public function properties(): Relation;
}
