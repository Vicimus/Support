<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface Configuration
{
    /**
     * Check a configuration value
     */
    public function check(string $property, mixed $default = null): mixed;
}
