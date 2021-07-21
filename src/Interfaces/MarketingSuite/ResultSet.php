<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;

/**
 * Interface ResultSet
 */
interface ResultSet
{
    /**
     * Get the rows
     * @return Collection
     */
    public function getRows(): Collection;
}
