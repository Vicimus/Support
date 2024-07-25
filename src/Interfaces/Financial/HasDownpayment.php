<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

interface HasDownpayment
{
    /**
     * The down payment amount
     */
    public function downpayment(): float;
}
