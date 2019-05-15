<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface Target
 */
interface Target
{
    /**
     * Convert the target into an array
     *
     * @return mixed[][]
     */
    public function toArray(): array;
}
