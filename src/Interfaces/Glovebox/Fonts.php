<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface Fonts
{
    /**
     * Get all available fonts
     * @return Font[]
     */
    public function get(): array;
}
