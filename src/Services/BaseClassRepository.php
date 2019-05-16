<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\ClassRepository;

/**
 * Class BaseClassRepository
 */
class BaseClassRepository implements ClassRepository
{
    /**
     * The repo of class names
     *
     * @var string[]
     */
    private $repo = [];

    /**
     * Get all instances that have been registered
     *
     * @return Collection
     */
    public function get(): Collection
    {
        $payload = [];
        foreach ($this->repo as $className) {
            $payload[] = app($className);
        }

        return new Collection($payload);
    }

    /**
     * Register one or many data services
     *
     * @param string|string[] $classes Register one or many data sources
     *
     * @return void
     */
    public function register($classes): void
    {
        $this->repo = array_merge($this->repo, (array) $classes);
    }
}
