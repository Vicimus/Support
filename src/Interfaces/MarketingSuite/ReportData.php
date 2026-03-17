<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface ReportData
{
    /**
     * Retrieve the id of the advertisement the stats are for
     */
    public function getAdId(): ?string;

    /**
     * Retrieve the name of the ad
     */
    public function getName(): string;

    /**
     * Implements toArray
     *
     * @return string[]
     */
    public function toArray(): array;
}
