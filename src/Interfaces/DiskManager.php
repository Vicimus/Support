<?php

namespace Vicimus\Support\Interfaces;

use InvalidArgumentException;

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
    public function disk($disk);
}
