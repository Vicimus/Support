<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasPrice
 */
interface HasPrice
{
    /**
     * This is the MSRP before fees and down payments, etc
     *
     */
    public function msrp(): float;

    /**
     * This is the all-in price with fees and freight and other expenses
     *
     */
    public function price(): float;
}
