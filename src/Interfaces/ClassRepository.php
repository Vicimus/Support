<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Repository
 */
interface ClassRepository
{
    /**
     * Check if a specific class is registered or not
     *
     * @param string $source The source to check
     *
     * @return bool
     */
    public function isRegistered(string $source): bool;

    /**
     * Register one or many data services
     *
     * @param string|string[] $classes Register one or many data sources
     *
     * @return void
     */
    public function register($classes): void;
}
