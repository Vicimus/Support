<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Files;

use Vicimus\Support\Interfaces\FileResolver;

/**
 * This class was created to make things using fopen more testable
 */
class ResourceResolver implements FileResolver
{
    /**
     * @return false|resource
     */
    public function file(string $path, string $mode = 'rb')
    {
        return fopen($path, $mode);
    }

    /**
     * Alias for file
     * @return resource | false
     */
    public function open(string $path, string $mode = 'rb')
    {
        return $this->file($path, $mode);
    }
}
