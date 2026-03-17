<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Vicimus\Support\Interfaces\Eloquent;

interface HasValues extends Eloquent, HasDatatype, HasHash
{
    /**
     * A property can have many values
     */
    public function values(): HasMany;
}
