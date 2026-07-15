<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Interfaces\MarketingSuite\Identifiable;
use Vicimus\Support\Interfaces\MarketingSuite\Placeholderable;
use Vicimus\Support\Interfaces\OemService;
use Vicimus\Support\Interfaces\Store;

/**
 * Interface PlaceholderData
 */
interface PlaceholderData
{
    /**
     * Get the campaign
     */
    public function campaign(): Placeholderable;

    /**
     * Get the identifiable entity
     */
    public function identifiable(): ?Identifiable;

    /**
     * Indicates if there are injections or not
     */
    public function injections(): bool;

    /**
     * Get the OEM name
     */
    public function oem(): OemService;

    /**
     * The OEM slug to render styling with, resolved for the recipient (for
     * example from the sold vehicle). Null falls back to the campaign OEM.
     */
    public function renderOem(): ?string;

    /**
     * Get the store to use
     */
    public function store(): ?Store;
}
