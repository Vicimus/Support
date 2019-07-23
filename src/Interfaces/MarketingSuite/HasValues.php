<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Interface HasValues
 */
interface HasValues
{

    /**
     * A property can have many values
     * @return HasMany
     */
    public function values(): HasMany;
}
