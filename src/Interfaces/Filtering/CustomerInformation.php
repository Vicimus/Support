<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\MarketingSuite\Customer;

interface CustomerInformation
{
    /**
     * @return LengthAwarePaginator|Collection|Customer[]
     */
    public function customers();

    public function paginator(): LengthAwarePaginator;

    public function collection(): Collection;
}
