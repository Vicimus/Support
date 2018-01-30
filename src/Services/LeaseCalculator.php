<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Vicimus\Support\Interfaces\Financial\HasDownpayment;
use Vicimus\Support\Interfaces\Financial\HasLeaseRate;
use Vicimus\Support\Interfaces\Financial\HasPrice;
use Vicimus\Support\Interfaces\Financial\HasRate;
use Vicimus\Support\Interfaces\Financial\HasTerm;
use Vicimus\Support\Interfaces\Financial\LeaseItem;

/**
 * Class Calculator
 */
class Calculator
{
    /**
     * Calculate a payment
     *
     * @param float|LeaseVehicle $rate
     * @param     $nper
     * @param     $pv
     * @param     $fv
     * @param int $type
     *
     * @return float
     */
    public function payment($rate, int $frequency = 12, ?int $nper = null, ?float $pv = null, ?float $fv = null, ?int $type = 1): float
    {
        if ($rate instanceof LeaseItem) {
            $vehicle = $rate;
            $rate = $this->rate($vehicle, $frequency);
            $nper = $this->nper($vehicle, $frequency);
            $pv = $this->presentValue($vehicle);
            $fv = $this->futureValue($vehicle, $vehicle);
        }

        $power = pow((1 + $rate), $nper);
        $leftSide = $pv - $fv / ($power);
        $rightSide = ((1 - (1 / $power)) / $rate);

        return round($leftSide / $rightSide, 2);
    }


    /**
     * Get the future value of a leaseable item
     *
     * @param $price
     * @param $residual
     *
     * @return float
     */
    public function futureValue($price, $residual): float
    {
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
     *
     * @param int|HasTerm $term      The term
     * @param int         $frequency The number of payments per year
     *
     * @return int
     */
    public function nper($term, int $frequency): int
    {
        if ($term instanceof HasTerm) {
            $term = $term->term();
        }

        return (int) round($term / 12 * $frequency, 0, PHP_ROUND_HALF_DOWN);
    }

    /**
     * @param float|HasPrice       $price The price
     * @param float|HasDownpayment $down  The downpayment amount
     *
     * @return float
     */
    public function presentValue($price, $down = 0): float
    {
        $total = $price;
        if ($price instanceof HasPrice) {
            $total = $price->price();
        }

        if ($price instanceof HasDownpayment) {
            $down = $price->downpayment();
        }

        if ($down instanceof HasDownpayment) {
            $down = $down->downpayment();
        }

        return $total - $down;
    }

    /**
     * Calculates the rate value used in PMT calculations
     *
     * @param float|HasRate $rate      The source rate
     * @param int           $frequency The frequency
     *
     * @return float
     */
    public function rate($rate, int $frequency = 12): float
    {
        if ($rate instanceof HasRate) {
            $rate = $rate->rate();
        }

        return round($rate / $frequency, 9);
    }
}
