<?php

namespace Vicimus\Support\Interfaces;

use InvalidArgumentException;
use League\Flysystem\FilesystemInterface;

/**
 * Interface Filesystem
 */
interface Filesystem extends FilesystemInterface
{
    /**
     * Get a url
     *
     * @param string $path The path to get a url for
     *
     * @return string
     *
     * @throws InvalidArgumentException
     */
    public function url($path);
}
