<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Files;

use Vicimus\Support\Interfaces\FileResolver;

/**
 * Class ResourceResolver
 *
 * This class was created to make things using fopen more testable
 */
class ResourceResolver implements FileResolver
{
    /**
     * Resolve a file stream resource
     *
     * @param string $path The path to resolve
     * @param string $mode The mode to open the resource with
     *
     * @return resource
     */
    public function file(string $path, string $mode = 'rb')
    {
        return fopen($path, $mode);
    }

    /**
     * Alias for file
     *
     * @param string $path The path
     * @param string $mode The mode
     *
     * @return resource
     */
    public function open(string $path, string $mode = 'rb')
    {
        return $this->file($path, $mode);
    }
}
