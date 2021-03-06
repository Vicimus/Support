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
     * @param string     $property The property to check
     * @param string|int $default  The default value
     *
     * @return mixed
     */
    public function check(string $property, $default = null);
}
