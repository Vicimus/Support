<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property int $id
 * @property string $type
 */
interface AssetRecord extends SimpleProperties
{
    /**
     * Get the owning campaign
     */
    public function assetable(): MorphTo;
}
