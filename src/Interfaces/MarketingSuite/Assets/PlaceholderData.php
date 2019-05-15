<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Interfaces\MarketingSuite\Campaign;
use Vicimus\Support\Interfaces\OemService;

/**
 * Interface PlaceholderData
 */
interface PlaceholderData
{
    /**
     * Get the campaign
     *
     * @return Campaign
     */
    public function campaign(): Campaign;

    /**
     * Indicates if there are injections or not
     * @return bool
     */
    public function injections(): bool;

    /**
     * Get the OEM name
     *
     * @return OemService
     */
    public function oem(): OemService;
}
