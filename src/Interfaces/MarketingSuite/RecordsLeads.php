<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface RecordsLeads
{
    /**
     * Retrieve the campaign id from the implementation
     *
     * @return int
     */
    public function campaignId(): int;
    
    /**
     * Retrieve the lead type id assigned to the campaign
     *
     * @return int|null
     */
    public function leadTypeId(): ?int;

    /**
     * Get the store id
     *
     * @return int
     */
    public function storeId(): int;
}
