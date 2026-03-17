<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Promotions;

interface Promotion
{
    /**
     * Check if the promotion is expired
     */
    public function expired(): bool;

    /**
     * Set the incentive
     */
    public function setIncentive(PromotionIncentive $incentive): void;
}
