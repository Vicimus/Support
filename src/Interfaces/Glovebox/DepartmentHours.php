<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface DepartmentHours
 */
interface DepartmentHours
{
    /**
     * Returns this instance's hours in an array format, making it easily iterable.
     *
     * @param bool $shortNames Whether to use 3 letter representation of the day
     *
     * @return mixed[] $day => $hours
     */
    public function daysHours(bool $shortNames = false): array;
}
