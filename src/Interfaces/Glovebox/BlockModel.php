<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface BlockModel
{
    /**
     * Get a setting value
     */
    public function setting(string $property, mixed $default = null): mixed;
}
