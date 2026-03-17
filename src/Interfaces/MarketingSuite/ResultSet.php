<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;

interface ResultSet
{
    /**
     * Get the rows
     */
    public function getRows(): Collection;
}
