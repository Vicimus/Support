<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface FileResolver
 */
interface FileResolver
{
    /**
     * Open a file and get the handle
     * @return resource
     */
    public function open(string $path, string $mode);
}
