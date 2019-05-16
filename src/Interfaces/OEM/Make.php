<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\OEM;

/**
 * Interface Make
 */
interface Make
{
    /**
     * Return the makes properties as variable data
     *
     * @return string[]
     */
    public function variables(): array;
}
