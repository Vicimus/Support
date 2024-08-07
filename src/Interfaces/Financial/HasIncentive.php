<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

interface HasIncentive
{
    /**
     * Get an incentive amount
     */
    public function incentive(): float;
}
