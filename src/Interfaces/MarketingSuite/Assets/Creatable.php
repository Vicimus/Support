<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use DateTimeInterface;

interface Creatable
{
    /**
     * Determine if an asset is active
     */
    public function active(): bool;

    /**
     * Retrieve a unique identifier for the asset
     */
    public function creativeName(): string;

    /**
     * Retrieve the assets end date
     */
    public function end(): ?DateTimeInterface;

    /**
     * Asset errored with the provided payload
     */
    public function error(string $message): void;

    /**
     * Retrieves the ad set
     */
    public function getAdSet(): ?AdSet;

    /**
     * Retrieve a link property value from the asset/asset assetable instance
     */
    public function link(string $field): ?string;

    /**
     * Determine if the asset type requires a render
     */
    public function needsRender(): bool;

    /**
     * Retrieve a path to the rendered pdf of the asset
     */
    public function path(): ?string;

    /**
     * Find a property value or return null
     */
    public function property(string $name, mixed $default = null): mixed;

    /**
     * Get a property value
     *
     * @param string $name The name of the property to get
     *
     */
    public function propertyWithoutFallback(string $name): mixed;

    /**
     * Record a property value
     */
    public function record(string $property, mixed $value = null, bool $hidden = false): void;

    /**
     * Record a property value, maintaining the old value if one exists.
     */
    public function replace(string $property, mixed $value = null): void;

    /**
     * Set the associated ad set id
     */
    public function setAdSet(int $adSetId): void;

    /**
     * Retrieve the assets start date
     */
    public function start(): ?DateTimeInterface;

    /**
     * Retrieve the slug type of the asset
     */
    public function type(): string;
}
