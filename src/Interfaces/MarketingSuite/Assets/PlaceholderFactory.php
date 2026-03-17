<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

interface PlaceholderFactory
{
    /**
     * Get a unique purl for a unique campaign/customer combination
     */
    public function purlUrl(PlaceholderData $data): string;
}
