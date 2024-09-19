<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\OEM\Make;

interface OemService
{
    /**
     * Get a make from the OEM api
     * @throws RestException
     */
    public function get(string $slug): Make;
}
