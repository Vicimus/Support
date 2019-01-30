<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;

/**
 * Interface QueryHandler
 */
interface QueryHandler
{
    /**
     * Pass the query to a handler
     *
     * @param Builder $query  The builder
     * @param Filter  $filter The filter
     * @param string  $type   The type of query being handled
     *
     * @return void
     */
    public function handle(Builder $query, Filter $filter, string $type): void;
}
