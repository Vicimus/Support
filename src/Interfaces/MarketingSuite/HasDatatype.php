<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface HasDatatype
{
    /**
     * Get the data type for this entity
     */
    public function datatype(): string;
}
