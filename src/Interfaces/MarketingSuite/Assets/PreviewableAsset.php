<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface PreviewableAsset
 */
interface PreviewableAsset
{
    /**
     * Get the content id for the asset
     */
    public function contentId(): int;

    /**
     * The external id from AC
     */
    public function externalId(): int;

    /**
     * The type of asset
     */
    public function type(): string;
}
