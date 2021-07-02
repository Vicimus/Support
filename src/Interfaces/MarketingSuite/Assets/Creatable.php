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
     * Retrieve a unique identifier for the asset
     * @return string
     */
    public function id(): string;

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
     * Record a property value
     *
     * @param string               $property The property to set
     * @param string|int|bool|null $value    The value to save
     * @param bool                 $hidden   The hidden state of a property
     *
     * @return void
     */
    public function record(string $property, $value = null, bool $hidden = false): void;

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
