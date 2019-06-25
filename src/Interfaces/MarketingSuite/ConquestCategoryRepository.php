<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\ClassRepository;

/**
 * Interface ConquestCategoryRepository*
 */
interface ConquestCategoryRepository extends ClassRepository
{
    /**
     * Get all repositories
     *
     * @return Collection|ConquestDataCategory[]
     */
    public function get(): Collection;
}
