<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Represents a campaign which can have its assets previewed
 */
interface Previewable
{
    /**
     * Do we want AC to return fallback assets
     */
    public function fallback(): bool;

    public function getId(): string | int | null;

    /**
     * The oem this campaign is associated with
     */
    public function oem(): string;

    /**
     * Get the entity to use as the placeholderable. Sometimes this is itself,
     * but other times it's a relation off the Previewable.
     */
    public function placeholderable(): Placeholderable;

    /**
     * Get the store id for this campaign
     */
    public function storeId(): int;

    /**
     * Supported assets
     * @return string[]
     */
    public function supported(): array;
}
