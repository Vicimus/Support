<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface DepartmentHours
{
    /**
     * Returns this instance's hours in an array format, making it easily iterable.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[] $day => $hours
     */
    public function daysHours(bool $shortNames = false): array;
}
