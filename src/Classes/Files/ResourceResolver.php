<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Files;

/**
 * Class ResourceResolver
 *
 * This class was created to make things using fopen more testable
 */
class ResourceResolver
{
    /**
     * Resolve a file stream resource
     *
     * @param string $path The path to resolve
     * @param string $mode The mode to open the resource with
     *
     * @return resource
     */
    public function file(string $path, string $mode = 'r')
    {
        return fopen($path, $mode);
    }
}
