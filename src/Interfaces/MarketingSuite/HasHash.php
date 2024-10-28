<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface HasHash
{
    /**
     * Get the hash for this entity that has properties
     */
    public function hash(): string;
}
