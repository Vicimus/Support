<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

/**
 * Interface Gatherer
 */
interface Gatherer
{
    /**
     * Get a count of how many customers a specific filter will match
     *
     * @param Filter $filter The filter to use to get the data with
     *
     * @return int
     */
    public function count(Filter $filter): int;
}
