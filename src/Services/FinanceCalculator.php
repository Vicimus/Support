<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

/**
 * Class PaymentCalculator
 */
class FinanceCalculator
{
    /**
     * @param float $rate             The interest rate
     * @param int   $frequency        The number of payments in one year
     * @param float $presentValue     The present value (price of the car)
     * @param int   $numberOfPayments The total number of payments
     *
     * @return float
     */
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
