<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use DateTimeInterface;

/**
 * Interface Creatable
 */
interface Creatable
{
    /**
     * Determine if an asset is active
     *
     */
    public function active(): bool;

    /**
     * Retrieve a unique identifier for the asset
     */
    public function creativeName(): string;

    /**
     * Retrieve the assets end date
     *
     */
    public function end(): ?DateTimeInterface;

    /**
     * Asset errored with the provided payload
     *
     * @param string $message The error message
     *
     */
    public function error(string $message): void;

    /**
     * Retrieves the ad set
     */
    public function getAdSet(): ?AdSet;

    /**
     * Retrieve a link property value from the asset/asset assetable instance
     *
     * @param string $field The link property name ('link'/'main_link')
     *
     */
    public function link(string $field): ?string;

    /**
     * Determine if the asset type requires a render
     *
     */
    public function needsRender(): bool;

    /**
     * Retrieve a path to the rendered pdf of the asset
     *
     */
    public function path(): ?string;

    /**
     * Find a property value or return null
     *
     * @param string          $name    The property to look for
     * @param string|int|bool $default The default value to return if the property doesn't exist
     *
     */
    public function property(string $name, string|int|bool|null $default = null): int|string|bool|null;

    /**
     * Record a property value
     *
     * @param string               $property The property to set
     * @param string|int|bool|null $value    The value to save
     * @param bool                 $hidden   The hidden state of a property
     *
     */
    public function record(string $property, string|int|bool|null $value = null, bool $hidden = false): void;

    /**
     * Record a property value, maintaining the old value if one exists.
     *
     * @param string               $property The property to set
     * @param string|int|bool|null $value    The value to save
     *
     */
    public function replace(string $property, string|int|bool|null $value = null): void;

    /**
     * Set the associated ad set id
     *
     * @param int $adSetId The ad set Id
     *
     */
    public function setAdSet(int $adSetId): void;

    /**
     * Retrieve the assets start date
     *
     */
    public function start(): ?DateTimeInterface;

    /**
     * Retrieve the slug type of the asset
     *
     */
    public function type(): string;
}
