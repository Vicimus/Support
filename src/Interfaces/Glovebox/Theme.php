<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface Theme
 */
interface Theme
{
    /**
     * Get a value
     *
     * @param string $property The property to get
     *
     * @return mixed
     */
    public function get(string $property);
}
