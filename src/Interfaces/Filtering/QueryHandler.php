<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface QueryHandler
 */
interface QueryHandler
{
    /**
     * Handle a query
     *
     * @param Builder      $query   The query
     * @param Filter       $filter  The filter
     * @param QueryTracker $tracker Track things
     *
     * @return void
     */
    public function handle(Builder $query, Filter $filter, ?QueryTracker $tracker): void;

    /**
     * Check if the handler is wanting to handle this filter
     *
     * @param Filter $filter The filter
     *
     * @return bool
     */
    public function handles(Filter $filter): bool;
}
