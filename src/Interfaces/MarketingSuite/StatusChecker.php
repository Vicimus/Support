<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface StatusChecker
 */
interface StatusChecker
{
    /**
     * Get a string representation of a campaign status
     *
     * @param Campaign $campaign The campaign
     *
     * @return string
     */
    public function statusString(Campaign $campaign): string;
}
