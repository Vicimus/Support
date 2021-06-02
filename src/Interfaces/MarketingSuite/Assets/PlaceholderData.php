<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Interfaces\MarketingSuite\Campaign;
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
     * @return Placeholderable
     */
    public function campaign(): Placeholderable;

    /**
     * Get the identifiable entity
     * @return Identifiable
     */
    public function identifiable(): Identifiable;

    /**
     * Indicates if there are injections or not
     * @return bool
     */
    public function injections(): bool;

    /**
     * Get the OEM name
     * @return OemService
     */
    public function oem(): OemService;

    /**
     * Get the store to use
     * @return Store|null
     */
    public function store(): ?Store;
}
