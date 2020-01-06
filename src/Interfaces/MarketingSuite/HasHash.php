<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface HasHash
 */
interface HasHash
{
    /**
     * Get the hash for this entity that has properties
     *
     * @return string
     */
    public function hash(): string;
}
