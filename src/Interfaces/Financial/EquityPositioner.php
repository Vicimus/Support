<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

interface EquityPositioner
{
    /**
     * Calculator equity position for finance
     */
    public function finance(int $value, int $paymentsRemaining, int | float $paymentValue): float;

    /**
     * Calculate equity position for lease
     */
    public function lease(int $value, int $paymentsRemaining, int | float $paymentValue, int | float $residual): float;
}
