<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface BlockModel
{
    public function setting(string $property, mixed $default = null): mixed;
}
