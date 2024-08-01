<?php

declare(strict_types=1);

namespace Vicimus\Support\Services;

use InvalidArgumentException;
use Vicimus\Support\Exceptions\CalculatorException;
use Vicimus\Support\Interfaces\Financial\HasDownpayment;
use Vicimus\Support\Interfaces\Financial\HasIncentive;
use Vicimus\Support\Interfaces\Financial\HasLeaseRate;
use Vicimus\Support\Interfaces\Financial\HasPrice;
use Vicimus\Support\Interfaces\Financial\HasRate;
use Vicimus\Support\Interfaces\Financial\HasTerm;
use Vicimus\Support\Interfaces\Financial\LeaseItem;

class LeaseCalculator
{
    /**
     * Get the future value of a lease item
     * @throws InvalidArgumentException
     */
    public function futureValue(float | HasPrice $price, float | HasLeaseRate $residual): float
    {
        if (!($price instanceof HasPrice) && !is_float($price) && !is_int($price)) {
            throw new InvalidArgumentException(
                'Price must be an int or float, or instance of HasPrice',
            );
        }

        if (!($residual instanceof HasLeaseRate) && !is_float($residual)) {
            throw new InvalidArgumentException(
                'Residual must be a float or instance of HasLeaseRate',
            );
        }

        if ($price instanceof HasPrice) {
            $price = $price->msrp();
        }

        if ($residual instanceof HasLeaseRate) {
            $residual = $residual->residual();
        }

        return $price * $residual;
    }

    /**
     * Number of periods calculation (part of PMT)
     * @throws InvalidArgumentException
     */
    public function nper(float | int | HasTerm $term, int $frequency): int
    {
        if (!($term instanceof HasTerm) && !is_int($term) && !is_float($term)) {
            throw new InvalidArgumentException(
                'Term must be an int or float (number of months in the term) or an instance of HasTerm',
            );
        }

        if ($term instanceof HasTerm) {
            $term = $term->term();
        }

        return (int) round($term / 12 * $frequency, 0, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Calculate a payment
     * @throws CalculatorException
     */
    public function payment(
        float | LeaseItem $rate,
        int $frequency = 12,
        ?int $nper = null,
        ?float $pValue = null,
        ?float $fValue = null
    ): float {
        if ($rate instanceof LeaseItem) {
            $vehicle = $rate;
            $rate = $this->rate($vehicle, $frequency);
            $nper = $this->nper($vehicle, $frequency);
            $pValue = $this->presentValue($vehicle);
            $fValue = $this->futureValue($vehicle, $vehicle);
        }

        if (!$nper) {
            throw new CalculatorException('Number of payment periods cannot be 0');
        }

        if (!$rate) {
            return round(($pValue - $fValue) / $nper, 2);
        }

        $power = (1 + $rate) ** $nper;

        $leftSide = $pValue - $fValue / $power;

        $rightSide = ((1 - (1 / $power)) / $rate);

        return round($leftSide / $rightSide, 2);
    }

    /**
     * Calculates the rate value used in PMT calculations
     */
    public function rate(float | HasRate $rate, int $frequency = 12): float
    {
        if ($rate instanceof HasRate) {
            $rate = $rate->rate();
        }

        return round($rate / $frequency, 9);
    }

    protected function presentValue(
        float | HasPrice $price,
        float | HasDownpayment $down = 0.0,
        float | HasIncentive $incentive = 0.0
    ): float {
        $total = $price;
        if ($price instanceof HasPrice) {
            $total = $price->price();
        }

        if ($price instanceof HasDownpayment) {
            $down = $price->downpayment();
        }

        if ($price instanceof HasIncentive) {
            $incentive = $price->incentive();
        }

        if ($down instanceof HasDownpayment) {
            $down = $down->downpayment();
        }

        if ($incentive instanceof HasIncentive) {
            $incentive = $incentive->incentive();
        }

        return $total - $down - $incentive;
    }
}
