<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface PackageManager
 */
interface PackageManager
{
    /**
     * Register a package
     *
     * @param string $name       The name
     * @param string $pathToLang The path to its lang files
     *
     * @return void
     */
    public function addPath(string $name, string $pathToLang): void;
}
