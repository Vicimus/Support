<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface StatusChecker
{
    /**
     * Get a string representation of a campaign status
     */
    public function statusString(Campaign $campaign): string;
}
