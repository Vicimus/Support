<?php

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface InventoryPageLocator
 */
interface InventoryPageLocator
{
    /**
     * Get a vdp page
     *
     * @param string $type The type of vdp to get
     *
     * @return Page
     */
    public function vdp($type);

    /**
     * Find a VLP page based on a url. Will fallback to 'all' if a specific type can't be found.
     * If all can't be found will 404.
     *
     * @param string $url The URL being accessed which we can use to find the matching page
     *
     * @return Page
     */
    public function vlp($url);
}
