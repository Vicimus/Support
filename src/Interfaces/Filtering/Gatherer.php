<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\MarketingSuite\Customer;

interface Gatherer
{
    /**
     * Get all customers by passing it a query
     *
     * @return Collection<Customer>
     */
    public function allCustomersFromQuery(Builder $query): Collection;

    /**
     * Get a count of how many customers a specific filter will match
     */
    public function count(Filter $filter, Campaign $campaign): int;

    /**
     * Get customer information
     */
    public function customers(
        ?Filter $filter,
        Campaign $campaign,
        ?ResultConfiguration $customerFilter = null,
        int $preferRecorded = 1,
        ?callable $mutator = null
    ): CustomerInformation;

    /**
     * Get stats for a filter and campaign
     */
    public function stats(Filter $filter, Campaign $campaign, bool $queryAssociated = false): Stats;

    /**
     * Get a customer query object
     */
    public function toCustomerQuery(Filter $filter, Campaign $campaign, ?callable $mutator = null): Builder;
}
