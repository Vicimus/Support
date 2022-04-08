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

    public function customers(
        ?Filter $filter,
        Campaign $campaign,
        ?ResultConfiguration $customerFilter = null,
        int $preferRecorded = 1
    );

    /**
     * Get stats for a filter and campaign
     *
     * @param Filter   $filter   The filter to use
     * @param Campaign $campaign The campaign to use
     *
     * @return Stats
     */
    public function stats(Filter $filter, Campaign $campaign): Stats;

    public function toCustomerQuery(Filter $filter, Campaign $campaign): Builder;
}
