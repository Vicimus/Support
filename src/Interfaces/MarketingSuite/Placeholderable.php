<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface Placeholderable
{
    /**
     * Retrieve the campaign id from the implementation
     */
    public function campaignId(): int;

    /**
     * Retrieve the campaign title from the implementation
     */
    public function campaignTitle(): string;

    public function contentId(): ?int;

    /**
     * Retrieve the description of the selected form for the campaign
     */
    public function formDescription(): string;

    /**
     * Retrieve the title of the selected form for the campaign
     */
    public function formTitle(): string;

    public function getTitle(): ?string;

    /**
     * Retrieve the oem name from the implementation
     */
    public function oem(): string;

    /**
     * Retrieve the purl domain id from the implementation
     */
    public function purlDomainId(): ?int;

    public function storeId(): int;

    /**
     * Campaign version
     */
    public function version(): int;
}
