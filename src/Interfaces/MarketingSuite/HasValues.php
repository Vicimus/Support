<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * Interface HasValues
 */
interface HasValues extends Eloquent, HasDatatype, HasHash
{

    /**
     * A property can have many values
     * @return HasMany
     */
    public function values(): HasMany;
}
