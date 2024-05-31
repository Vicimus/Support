<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\MarketingSuite\Customer;

/**
 * Customer information returned by gatherers
 */
interface CustomerInformation
{
    /**
     */
    public function collection(): Collection;

    /**
     * @return LengthAwarePaginator|Collection|Customer[]
     */
    public function customers(): LengthAwarePaginator|Collection|array;

    /**
     */
    public function paginator(): LengthAwarePaginator;
}
