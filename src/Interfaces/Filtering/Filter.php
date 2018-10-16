<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

/**
 * Interface Filter
 */
interface Filter
{
    /**
     * Convert all filter properties into a payload array that we can
     * use to pass to various services
     *
     * @return string[]
     */
    public function payload(): array;
}
