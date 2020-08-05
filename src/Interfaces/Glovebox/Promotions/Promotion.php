<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox\Promotions;

/**
 * Interface Promotion
 */
interface Promotion
{
    /**
     * Check if the promotion is expired
     * @return bool
     */
    public function expired(): bool;

    /**
     * Set the incentive
     *
     * @param PromotionIncentive $incentive The incentive to set
     *
     * @return void
     */
    public function setIncentive(PromotionIncentive $incentive): void;
}
