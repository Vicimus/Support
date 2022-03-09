<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Interfaces\OEM\Make;

/**
 * Interface OemService
 */
interface OemService
{
    /**
     * Get a make from the OEM api
     *
     * @param string $slug The Make to get
     *
     * @return Make
     * @throws RestException
     *
     */
    public function get(string $slug): Make;
}
