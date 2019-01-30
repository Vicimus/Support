<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface EquityPositioner
 */
interface EquityPositioner
{
    /**
     * Calculator equity position for finance
     *
     * @param int       $value             The current value of the vehicle (wholesale)
     * @param int       $paymentsRemaining The number of payments remaining
     * @param int|float $paymentValue      The payment amount
     *
     * @return int
     */
    public function finance(int $value, int $paymentsRemaining, $paymentValue): float;

    /**
     * Calculate equity position for lease
     *
     * @param int       $value             The current value of the vehicle
     * @param int       $paymentsRemaining The number of payments remaining
     * @param int|float $paymentValue      The payment amount
     * @param int|float $residual          The residual value
     *
     * @return int
     */
    public function lease(int $value, int $paymentsRemaining, $paymentValue, $residual): float;
}
