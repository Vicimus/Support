<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

/**
 * Interface Renderable
 */
interface Renderable
{
    /**
     * Get the content id used for this renderable
     * @return int
     */
    public function contentId(): int;

    /**
     * Get the external id used by this renderable
     * @return int
     */
    public function externalId(): int;

    /**
     * Get the format we can render this item in (png, jpg, html, pdf)
     * @return string
     */
    public function format(): string;

    /**
     * What is the height of this item
     * @return int
     */
    public function height(): int;

    /**
     * A name to give this renderable item
     * @return string
     */
    public function name(): string;

    /**
     * If rendered before, return the path to where we can access this render
     * @return string|null
     */
    public function path(): ?string;

    /**
     * Get the rendered markup
     * @return string
     */
    public function rendered(): string;

    /**
     * The store id that owns this item
     * @return int
     */
    public function storeId(): int;

    /**
     * Touch the timestamps
     * @return void
     */
    public function touch(): void;

    /**
     * Get the asset type slug
     *
     * @return string
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
     * @return int
     */
    public function width(): int;
}
