<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface QueryHandlerRepository
 */
interface QueryHandlerRepository
{
    /**
     * Pass the query to a handler
     *
     * @param Builder           $query   The builder
     * @param Filter            $filter  The filter
     * @param null|QueryTracker $tracker A tracker instance
     * @param string            $type    The type of query being handled
     *
     */
    public function handle(Builder $query, Filter $filter, ?QueryTracker $tracker, string $type): Builder;
}
