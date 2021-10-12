<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface ReportData
 */
interface ReportData
{
    /**
     * Retrieve the id of the advertiment the stats are for
     * @return string|null
     */
    public function getAdId(): ?string;

    /**
     * Retrieve the name of the ad
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Implements toArray
     *
     * @return string[]
     */
    public function toArray(): array;
}
