<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface Renderable
 */
interface Renderable
{
    /**
     * Get the content id used for this renderable
     */
    public function contentId(): int;

    /**
     * Get the external id used by this renderable
     */
    public function externalId(): int;

    /**
     * Get the format we can render this item in (png, jpg, html, pdf)
     */
    public function format(): string;

    /**
     * What is the height of this item
     */
    public function height(): int;

    /**
     * A name to give this renderable item
     */
    public function name(): string;

    /**
     * If rendered before, return the path to where we can access this render
     */
    public function path(): ?string;

    /**
     * Get the rendered markup
     */
    public function rendered(): string;

    /**
     * The store id that owns this item
     */
    public function storeId(): int;

    /**
     * Touch the timestamps
     */
    public function touch(): void;

    /**
     * Get the asset type slug
     *
     */
    public function type(): string;

    /**
     * Update the renderable record with new parameters
     *
     * @param string $newPath The new path to set
     *
     * @return Renderable
     */
    public function update(string $newPath): self;

    /**
     * What is the width of this item
     */
    public function width(): int;
}
