<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use ErrorException;

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
     *
     * @throws ErrorException
     */
    public function open(string $path, string $mode);
}
