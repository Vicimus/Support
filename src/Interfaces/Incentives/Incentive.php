<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Incentives;

/**
 * Incentive
 */
interface Incentive
{
    /**
     * Does this incentive have a lease rate
     * @return bool
     */
    public function hasLeaseRate(): bool;

    /**
     * Does this incentive have a finance rate
     * @return bool
     */
    public function hasRate(): bool;

    /**
     * Get the highest rate in the program
     * @return Term
     */
    public function highestRate(): Term;

    /**
     * Get the highest term in the program
     * @return Term
     */
    public function highestTerm(): Term;

    /**
     * Get the institution
     * @return Institution
     */
    public function institution(): Institution;

    /**
     * Is this residuals
     * @return bool
     */
    public function isResiduals(): bool;

    /**
     * Get the lowest rate in the program
     * @return Term
     */
    public function lowestRate(): Term;

    /**
     * Get the lowest term in the program
     * @return Term
     */
    public function lowestTerm(): Term;
}
