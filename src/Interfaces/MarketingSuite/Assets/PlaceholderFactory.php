<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface PlaceholderFactory
 */
interface PlaceholderFactory
{
    /**
     * Get a unique purl for a unique campaign/customer combination
     *
     * @param PlaceholderData $data The placeholder data
     *
     * @return string
     */
    public function purlUrl(PlaceholderData $data): string;
}
