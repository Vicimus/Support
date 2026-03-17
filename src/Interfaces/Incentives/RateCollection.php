<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Incentives;

interface RateCollection
{
    /**
     * How many rates
     */
    public function count(): int;

    /**
     * Get the highest rate
     * @throws IncentiveException
     */
    public function highestRate(): Term;

    /**
     * Get the lowest term in months
     * @throws IncentiveException
     */
    public function highestTerm(): Term;

    /**
     * Get the lowest rate available
     *
     * @throws IncentiveException
     */
    public function lowestRate(): Term;

    /**
     * Get the lowest term in months
     *
     * @throws IncentiveException
     */
    public function lowestTerm(): Term;
}
