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
     * @return Collection<Customer>
     */
    public function collection(): Collection;

    /**
     * @return LengthAwarePaginator<Customer>|Collection<Customer>
     */
    public function customers(): LengthAwarePaginator | Collection;

    public function paginator(): LengthAwarePaginator;
}
