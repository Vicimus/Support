<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;

interface QueryHandlerRepository
{
    /**
     * Pass the query to a handler
     */
    public function handle(Builder $query, Filter $filter, ?QueryTracker $tracker, string $type): Builder;
}
