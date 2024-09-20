<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface PackageManager
{
    /**
     * Register a package
     */
    public function addPath(string $name, string $pathToLang): void;
}
