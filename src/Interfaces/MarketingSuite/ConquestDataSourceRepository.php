<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Interfaces\ClassRepository;

interface ConquestDataSourceRepository extends ClassRepository
{
    /**
     * Get sources by category
     */
    public function category(string $category): Collection;

    /**
     * Get all repositories
     *
     * @return Collection<ConquestDataSourceInfo>
     */
    public function get(): Collection;
}
