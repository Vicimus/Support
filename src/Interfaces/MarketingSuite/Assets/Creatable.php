<?php declare(strict_types = 1);

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
     * @return bool
     */
    public function active(): bool;

    /**
     * Retrieve a unique identifier for the asset
     * @return string
     */
    public function creativeName(): string;

    /**
     * Retrieve the assets end date
     *
     * @return DateTimeInterface|null
     */
    public function end(): ?DateTimeInterface;

    /**
     * Asset errored with the provided payload
     *
     * @param string $message The error message
     *
     * @return void
     */
    public function error(string $message): void;

    /**
     * Retrieves the ad set
     * @return AdSet|null
     */
    public function getAdSet(): ?AdSet;

    /**
     * Retrieve a link property value from the asset/asset assetable instance
     *
     * @param string $field The link property name ('link'/'main_link')
     *
     * @return string
     */
    public function link(string $field): ?string;

    /**
     * Determine if the asset type requires a render
     *
     * @return bool
     */
    public function needsRender(): bool;

    /**
     * Retrieve a path to the rendered pdf of the asset
     *
     * @return string
     */
    public function path(): ?string;

    /**
     * Find a property value or return null
     *
     * @param string          $name    The property to look for
     * @param string|int|bool $default The default value to return if the property doesn't exist
     *
     * @return int|string|bool|null
     */
    public function property(string $name, $default = null);

    /**
     * Get a property value
     *
     * @param string $name The name of the property to get
     *
     * @return bool|int|string|null
     */
    public function propertyWithoutFallback(string $name);


    /**
     * Record a property value
     *
     * @param string               $property The property to set
     * @param string|int|bool|null $value    The value to save
     * @param int                  $hidden   The hidden state of a property
     *
     * @return void
     */
    public function record(string $property, $value = null, int $hidden = 0): void;

    /**
     * Record a property value, maintaining the old value if one exists.
     *
     * @param string               $property The property to set
     * @param string|int|bool|null $value    The value to save
     *
     * @return void
     */
    public function replace(string $property, $value = null): void;

    /**
     * Set the associated ad set id
     *
     * @param int $adSetId The ad set Id
     *
     * @return void
     */
    public function setAdSet(int $adSetId): void;

    /**
     * Retrieve the assets start date
     *
     * @return DateTimeInterface|null
     */
    public function start(): ?DateTimeInterface;

    /**
     * Retrieve the slug type of the asset
     *
     * @return string
     */
    public function type(): string;
}
