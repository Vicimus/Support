<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Tel;

use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;

interface CustomerListsContract
{
    /**
     * Create a new customer list
     *
     * @param int         $storeId   The store making the request
     * @param string      $name      The name of the list
     * @param Carbon      $start     The date the calls tart
     * @param Carbon      $end       The date the calls end
     * @param string|null $script    The script read on the call
     * @param int[]       $customers The customers associated with the list
     *
     * @return CustomerListContract
     * @throws GuzzleException
     */
    public function create(
        int $storeId,
        string $name,
        Carbon $start,
        Carbon $end,
        ?string $script,
        array $customers
    ): CustomerListContract;

    /**
     * Update the customer list for a campaign
     *
     * @param int   $storeId        The store making the request
     * @param int   $customerListId The id of the existing customer list
     * @param int[] $customers      The customers associated with the list
     *
     * @return CustomerListContract
     * @throws GuzzleException
     */
    public function update(
        int $storeId,
        int $customerListId,
        array $customers
    ): CustomerListContract;

}
