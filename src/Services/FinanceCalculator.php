<?php

declare(strict_types=1);

namespace Vicimus\Support\Services;

class FinanceCalculator
{
    public function payment(float $rate, int $frequency, float $presentValue, int $numberOfPayments): float
    {
        if (!$rate) {
            if ($frequency === 12) {
                return round($presentValue / $numberOfPayments, 2);
            }

            return round($presentValue / (($numberOfPayments / 12) * $frequency), 2);
        }

        $numberOfPayments *= ($frequency / 12);
        $ratePerPeriod = $rate / 100 / $frequency;
        $result = ($ratePerPeriod * $presentValue) / (1 - ((1 + $ratePerPeriod) ** ($numberOfPayments * -1)));

        return round($result, 2);
    }
}
