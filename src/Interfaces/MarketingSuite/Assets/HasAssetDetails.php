<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

interface HasAssetDetails
{
    /**
     * Set the error on asset details with the provided message
     */
    public function error(string $message): void;
}
