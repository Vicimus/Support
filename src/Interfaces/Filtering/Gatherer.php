<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Vicimus\Support\Classes\ImmutableObject;

/**
 * Interface Gatherer
 */
interface Gatherer
{
    /** Ignore recorded customers */
    public const MODE_IGNORE_RECORDED = 2;

    /** Prefer recorded customers if available */
    public const MODE_PREFER_RECORDED = 1;

    /**
     * Get a count of how many customers a specific filter will match
     *
     * @param Filter        $filter   The filter to use to get the data with
     * @param Campaign|null $campaign Use a campaign to improve accuracy
     *
     * @return int
     */
    public function count(Filter $filter, ?Campaign $campaign = null): int;

    /**
     * Gather customers for a given filter and campaign
     *
     * @param Filter|null         $filter         The filter
     * @param Campaign            $campaign       The campaign
     * @param CustomerFilter|null $customerFilter Customer filter object
     * @param int                 $preferRecorded The mode to use
     *
     * @return CustomerInformation
     */
    public function customers(
        ?Filter $filter,
        Campaign $campaign,
        ?CustomerFilter $customerFilter = null,
        int $preferRecorded = GathererContract::MODE_PREFER_RECORDED
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
}
