<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface ThemeManager
 */
interface ThemeManager
{
    /**
     * Run Grunt Web in the Eevee directory to recompile the theme scss
     *
     * @param string $command The command to run
     *
     * @return Result
     */
    public function refresh(string $command): Result;
}
