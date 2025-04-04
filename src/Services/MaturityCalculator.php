<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Carbon\Carbon;
use DateTimeInterface;

/**
 *
 */
class MaturityCalculator
{
    /**
     * @param Carbon   $purchaseDate     The purchase date of the vehicle
     * @param int      $term             The term in unknown units
     * @param int|null $paymentFrequency The payment frequency we figured out
     *
     * @return DateTimeInterface
     */
    public function calculate(Carbon $purchaseDate, int $term, ?int &$paymentFrequency = null): ?DateTimeInterface
    {
        // Cash deal or invalid term
        if ($term <= 1 || $term > 208) {
            return null;
        }

        $biWeekly = $term % 26 === 0;

        // Normal bi-weekly term
        if ($biWeekly) {
            $paymentFrequency = 26;
            return $purchaseDate->copy()->addYears($term / 26);
        }

        // Messed up bi-weekly term
        if ($term > 96) {
            $paymentFrequency = 26;
            $daysToMaturity = round($term / 26 * 365);
            return $purchaseDate->copy()->addDays((int) $daysToMaturity);
        }

        $paymentFrequency = 12;
        return $purchaseDate->copy()->addMonths($term);
    }
}
