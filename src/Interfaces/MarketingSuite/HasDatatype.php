<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface HasDatatype
 */
interface HasDatatype
{
    /**
     * Get the data type for this entity
     * @return string
     */
    public function datatype(): string;
}
