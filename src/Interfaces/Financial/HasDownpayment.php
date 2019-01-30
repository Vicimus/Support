<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasDownpayment
 */
interface HasDownpayment
{
    /**
     * The downpayment amount
     *
     * @return float
     */
    public function downpayment(): float;
}
