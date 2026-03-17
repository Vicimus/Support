<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use ErrorException;

interface FileResolver
{
    /**
     * Open a file and get the handle
     *
     * @return resource
     *
     * @throws ErrorException
     */
    public function open(string $path, string $mode);
}
