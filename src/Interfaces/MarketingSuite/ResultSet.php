<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Illuminate\Support\Collection;

interface ResultSet
{
    /**
     * Get the rows
     * @return Collection
     */
    public function getRows(): Collection;
}
