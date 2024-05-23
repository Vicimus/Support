<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface BlockModel
 */
interface BlockModel
{
    /**
     * Get a setting value
     *
     * @param string $property The property to check
     * @param mixed  $default  The default value
     *
     */
    public function setting(string $property, mixed $default = null): mixed;
}
