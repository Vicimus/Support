<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasRate
 */
interface HasRate
{
    /**
     * Get the rate
     *
     * @return float
     */
    public function rate(): float;
}
