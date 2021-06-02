<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface Placeholderable
 */
interface Placeholderable
{
    /**
     * Retrieve the campaign id from the implementation
     *
     * @return int
     */
    public function campaignId(): int;

    /**
     * Retrieve the campaign title from the implementation
     *
     * @return string
     */
    public function campaignTitle(): string;

    /**
     * Retrieve the oem name from the implementation
     *
     * @return int|null
     */
    public function oem(): string;

    /**
     * Retrieve the purl domain id from the implementation
     *
     * @return int|null
     */
    public function purlDomainId(): ?int;
}
