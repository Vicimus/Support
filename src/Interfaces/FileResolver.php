<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface FileResolver
 */
interface FileResolver
{
    /**
     * Open a file and get the handle
     *
     * @param string $path The path to open
     * @param string $mode The mode to use
     *
     * @return resource
     */
    public function open(string $path, string $mode);
}
