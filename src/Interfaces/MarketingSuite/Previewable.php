<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface Previewable 
{
    /**
     * The oem this campaign is associated with
     *
     * @return string
     */
    public function oem(): string;

    /**
     * Supported assets
     * @return string[]
     */
    public function supported(): array;

    /**
     * Get the store id for this campaign
     * @return int
     */
    public function storeId(): int;
}
