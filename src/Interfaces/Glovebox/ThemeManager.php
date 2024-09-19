<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface ThemeManager
{
    /**
     * Run Grunt Web in the Eevee directory to recompile the theme scss
     */
    public function refresh(string $command): Result;
}
