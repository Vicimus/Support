<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Incentives;

interface RateCollection
{
    /**
     * How many rates
     * @return int
     */
    public function count(): int;

    /**
     * Get the highest rate
     *
     * @return Term
     * @throws IncentiveException
     */
    public function highestRate(): Term;

    /**
     * Get the lowest term in months
     *
     * @return Term
     *
     * @throws IncentiveException
     */
    public function highestTerm(): Term;

    /**
     * Get the lowest rate available
     *
     * @return Term
     *
     * @throws IncentiveException
     */
    public function lowestRate(): Term;

    /**
     * Get the lowest term in months
     *
     * @return Term
     *
     * @throws IncentiveException
     */
    public function lowestTerm(): Term;
}
