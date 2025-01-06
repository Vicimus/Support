<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface RecordsLeads
{
    /**
     * Retrieve the campaign id from the implementation
     */
    public function campaignId(): int;

    /**
     * Retrieve the lead type id assigned to the campaign
     */
    public function leadTypeId(): ?int;

    /**
     * Get the store id
     */
    public function storeId(): int;
}
