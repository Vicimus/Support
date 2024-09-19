<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasIdentifiers
{
    /**
     * A campaign has many identifiers
     */
    public function identifiers(): MorphMany;
}
