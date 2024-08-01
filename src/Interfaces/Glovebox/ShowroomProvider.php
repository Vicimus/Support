<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface ShowroomProvider
{
    /**
     * Get an array of preferred showroom trims
     *
     * @return string[]|array
     */
    public function preferred(): array;
}
