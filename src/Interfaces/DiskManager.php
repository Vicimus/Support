<?php

namespace Vicimus\Support\Interfaces;

use InvalidArgumentException;
use League\Flysystem\Filesystem;

/**
 * Class DiskManager
 */
interface DiskManager
{
    /**
     * Get a disk instance
     *
     * @param string $disk The disk name
     *
     * @return Filesystem
     *
     * @throws InvalidArgumentException
     */
    public function disk(string $disk);
}
