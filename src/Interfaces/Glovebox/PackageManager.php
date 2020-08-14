<?php

namespace Vicimus\Support\Interfaces\Glovebox;

interface PackageManager
{
    /**
     * Add a path to the package manager
     *
     * @param string $namespace The namespace
     * @param string $path      The path
     *
     * @return void
     */
    public function addPath($namespace, $path);
}
