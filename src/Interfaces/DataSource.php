<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Forces specific behaviour from data sources
 *
 * @author Jordan
 */
interface DataSource
{
    /**
     * Return a slug to identify the data source as unique
     *
     * @return string
     */
    public function slug(): string;

    /**
     * Return a wonderful name for your data source
     *
     * @return string
     */
    public function name(): string;

    /**
     * Return an array of data points
     *
     * @return mixed[]
     */
    public function points(): array;

    /**
     * Handle a data point request
     *
     * @param string   $point      The point requested
     * @param string[] $userParams The parameters to pass along
     *
     * @return mixed
     */
    public function handle(string $point, array $userParams = []);
}
