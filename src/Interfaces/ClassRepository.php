<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface Repository
 */
interface ClassRepository
{
    /**
     * Register one or many data services
     *
     * @param string|string[] $classes Register one or many data sources
     *
     * @return void
     */
    public function register($classes): void;
}
