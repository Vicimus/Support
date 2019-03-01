<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface Configuration
 */
interface Configuration
{
    /**
     * Check a configuration value
     *
     * @param string $property The property to check
     *
     * @return mixed
     */
    public function check(string $property);
}
