<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Tel;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Customer list customer service contract
 */
interface CustomerListCustomersContract
{
    /**
     * Update the customer list for a campaign
     *
     * @param int   $storeId    The store making the request
     * @param int   $prospectId The prospect id of the associated customer
     * @param string[] $data    The data to update with
     *
     * @return CustomerListContract
     * @throws GuzzleException
     */
    public function update(
        int $storeId,
        int $prospectId,
        array $data
    ): void;
}
