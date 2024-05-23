<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Forces specific behaviour from data sources
 */
interface DataSource
{
    /**
     * Handle a data point request
     *
     * @param string   $point      The point requested
     * @param string[] $userParams The parameters to pass along
     *
     */
    public function handle(string $point, array $userParams = []): mixed;

    /**
     * Return a wonderful name for your data source
     *
     */
    public function name(): string;

    /**
     * Return an array of data points
     *
     * @return mixed[]
     */
    public function points(): array;

    /**
     * Return a slug to identify the data source as unique
     *
     */
    public function slug(): string;
}
