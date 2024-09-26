<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface Theme
{
    public function get(string $property): mixed;
}
