<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface InventoryPageLocator
{
    /**
     * Get a vdp page
     */
    public function vdp(string $type): Page;

    /**
     * Find a VLP page based on a url. Will fallback to 'all' if a specific type can't be found.
     * If all can't be found will 404.
     */
    public function vlp(string $url): Page;
}
