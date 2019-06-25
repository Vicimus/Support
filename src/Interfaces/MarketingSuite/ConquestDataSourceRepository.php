<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Interfaces\ClassRepository;

/**
 * Interface ConquestDataSourceRepository
 */
interface ConquestDataSourceRepository extends ClassRepository
{
    /**
     * Get sources by category
     *
     * @param string $category The category
     *
     * @return Collection
     */
    public function category(string $category): Collection;

    /**
     * Get all repositories
     *
     * @return Collection|ConquestDataSourceInfo[]
     */
    public function get(): Collection;
}
