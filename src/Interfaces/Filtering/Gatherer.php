<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Retention\Models\External\Customer;

/**
 * Interface Gatherer
 */
interface Gatherer
{
    /**
     * Get all customers by passing it a query
     *
     * @param Builder $query The query
     *
     * @return Collection|Customer[]
     */
    public function allCustomersFromQuery(Builder $query): Collection;

    /**
     * Get a count of how many customers a specific filter will match
     *
     * @param Filter   $filter   The filter to use to get the data with
     * @param Campaign $campaign Use a campaign to improve accuracy
     *
     * @return int
     */
    public function count(Filter $filter, Campaign $campaign): int;

    /**
     * Get customer information
     *
     * @param Filter|null              $filter         The filter
     * @param Campaign                 $campaign       The campaign
     * @param ResultConfiguration|null $customerFilter The customer filter info for paging
     * @param int                      $preferRecorded Prefer recorded or theoretical
     * @param callable|null            $mutator        Apply constraints to the query
     *
     * @return mixed
     */
    public function customers(
        ?Filter $filter,
        Campaign $campaign,
        ?ResultConfiguration $customerFilter = null,
        int $preferRecorded = 1,
        ?callable $mutator = null
    );

    /**
     * Get stats for a filter and campaign
     *
     * @param Filter   $filter          The filter to use
     * @param Campaign $campaign        The campaign to use
     * @param bool     $queryAssociated Should just query associated customers for stats
     *
     * @return Stats
     */
    public function stats(Filter $filter, Campaign $campaign, bool $queryAssociated = false): Stats;

    /**
     * Get a customer query object
     *
     * @param Filter   $filter   The filter
     * @param Campaign $campaign The campaign
     *
     * @return Builder
     */
    public function toCustomerQuery(Filter $filter, Campaign $campaign): Builder;
}
