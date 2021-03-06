<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasIncentive
 */
interface HasIncentive
{
    /**
     * Get an incentive amount
     *
     * @return float
     */
    public function incentive(): float;
}
