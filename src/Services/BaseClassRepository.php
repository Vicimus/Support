<?php

declare(strict_types=1);

namespace Vicimus\Support\Services;

use Illuminate\Support\Collection;
use Vicimus\Support\Interfaces\ClassRepository;

class BaseClassRepository implements ClassRepository
{
    /**
     * The repo of class names
     * @var string[]
     */
    private array $repo = [];

    /**
     * Get all instances that have been registered
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
     * Check if a specific class is registered or not
     */
    public function isRegistered(string $source): bool
    {
        return in_array($source, $this->repo, true);
    }

    /**
     * Register one or many data services
     *
     * @param string|string[] $classes Register one or many data sources
     */
    public function register(string | array $classes): void
    {
        $this->repo = array_merge($this->repo, (array) $classes);
    }
}
