<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Database\Eloquent\Builder;

interface QueryHandler
{
    public function handle(Builder $query, Filter $filter, ?QueryTracker $tracker): void;

    public function handles(Filter $filter): bool;
}
