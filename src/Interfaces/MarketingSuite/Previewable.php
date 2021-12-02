<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Shared\Contracts\HasAssets;

/**
 * Represents a campaign which can have it's assets previewed
 */
interface Previewable extends HasAssets
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
     * Get the entity to use as the placeholderable. Sometimes this is itself,
     * but other times it's a relation off the Previewable.
     * @return Placeholderable
     */
    public function placeholderable(): Placeholderable;

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
