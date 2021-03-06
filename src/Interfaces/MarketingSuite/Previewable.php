<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Represents a campaign which can have it's assets previewed
 */
interface Previewable
{
    /**
     * Do we want AC to return fallback assets
     * @return bool
     */
    public function fallback(): bool;

    /**
     * The oem this campaign is associated with
     *
     * @return string
     */
    public function oem(): string;

    /**
     * Get the store id for this campaign
     * @return int
     */
    public function storeId(): int;

    /**
     * Supported assets
     * @return string[]
     */
    public function supported(): array;
}
