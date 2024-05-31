<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface ShowroomProvider
 */
interface ShowroomProvider
{
    /**
     * Get an array of preferred showroom trims
     *
     * @return string[]|array
     */
    public function preferred(): array;
}
