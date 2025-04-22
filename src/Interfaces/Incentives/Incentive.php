<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Incentives;

interface Incentive
{
    /**
     * Does this incentive have a lease rate
     */
    public function hasLeaseRate(): bool;

    /**
     * Does this incentive have a finance rate
     */
    public function hasRate(): bool;

    /**
     * Get the highest rate in the program
     */
    public function highestRate(): Term;

    /**
     * Get the highest term in the program
     */
    public function highestTerm(): Term;

    /**
     * Get the institution
     */
    public function institution(): Institution;

    /**
     * Is this residuals
     */
    public function isResiduals(): bool;

    /**
     * Get the lowest rate in the program
     */
    public function lowestRate(): Term;

    /**
     * Get the lowest term in the program
     */
    public function lowestTerm(): Term;
}
