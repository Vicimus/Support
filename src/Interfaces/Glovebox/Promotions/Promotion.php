<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Promotions;

/**
 * Interface Promotion
 */
interface Promotion
{
    /**
     * Check if the promotion is expired
     */
    public function expired(): bool;

    /**
     * Set the incentive
     *
     * @param PromotionIncentive $incentive The incentive to set
     *
     */
    public function setIncentive(PromotionIncentive $incentive): void;
}
