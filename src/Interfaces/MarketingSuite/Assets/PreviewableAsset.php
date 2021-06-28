<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface PreviewableAsset
 */
interface PreviewableAsset
{
    /**
     * Get the content id for the asset
     * @return int
     */
    public function contentId(): int;

    /**
     * The external id from AC
     * @return int
     */
    public function externalId(): int;

    /**
     * The type of asset
     * @return string
     */
    public function type(): string;
}
