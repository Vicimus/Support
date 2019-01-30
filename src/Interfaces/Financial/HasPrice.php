<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasPrice
 */
interface HasPrice
{
    /**
     * This is the MSRP before fees and down payments, etc
     *
     * @return float
     */
    public function msrp(): float;

    /**
     * This is the all-in price with fees and freight and other expenses
     *
     * @return float
     */
    public function price(): float;
}
