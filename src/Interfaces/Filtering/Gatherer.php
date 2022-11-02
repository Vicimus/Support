<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface Gatherer
 */
interface Gatherer
{
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
     *
     * @return CustomerInformation
     */
    public function customers(
        ?Filter $filter,
        Campaign $campaign,
        ?ResultConfiguration $customerFilter = null,
        int $preferRecorded = 1
    ): CustomerInformation;

    /**
     * Get stats for a filter and campaign
     *
     * @param Filter   $filter   The filter to use
     * @param Campaign $campaign The campaign to use
     *
     * @return Stats
     */
    public function stats(Filter $filter, Campaign $campaign): Stats;

    /**
     * Get a customer query object
     *
     * @param Filter        $filter   The filter
     * @param Campaign      $campaign The campaign
     * @param callable|null $mutator  Optionally provide a mutator to mutate the query
     *
     * @return Builder
     */
    public function toCustomerQuery(Filter $filter, Campaign $campaign, ?callable $mutator = null): Builder;
}
