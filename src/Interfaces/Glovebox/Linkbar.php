<?php

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface Linkbar
 */
interface Linkbar
{
    /**
     * Get the output of the linkbar
     * @return string
     */
    public function getOutput();

    /**
     * Does it have links
     * @return bool
     */
    public function hasLinks();
}
