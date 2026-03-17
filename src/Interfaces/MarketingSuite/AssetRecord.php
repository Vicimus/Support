<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\MorphTo;

interface AssetRecord extends SimpleProperties
{
    /**
     * Get the owning campaign
     */
    public function assetable(): MorphTo;

    public function getId(): string | int | null;

    public function getType(): string;

    public function isActive(): bool;
}
