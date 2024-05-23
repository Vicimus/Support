<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasRate
 */
interface HasRate
{
    /**
     * Get the rate
     *
     */
    public function rate(): float;
}
