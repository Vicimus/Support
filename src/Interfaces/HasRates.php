<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

interface HasRates
{
    /**
     * Get the rate
     *
     * @return float
     */
    public function rate(): float;
}
