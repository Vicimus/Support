<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Tel;

use GuzzleHttp\Exception\GuzzleException;

interface CustomerListCustomersContract
{
    /**
     * Update the customer list for a campaign
     *
     * @param int      $storeId    The store making the request
     * @param int      $prospectId The prospect id of the associated customer
     * @param string[] $data       The data to update with
     *
     * @throws GuzzleException
     */
    public function update(
        int $storeId,
        int $prospectId,
        array $data
    ): void;
}
