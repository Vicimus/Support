<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

interface QueryTracker
{
    public function set(string $property, mixed $value): void;
}
