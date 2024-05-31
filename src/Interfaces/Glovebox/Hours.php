<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface Hours
 */
interface Hours
{
    /**
     * Get department hour info for a specific department
     *
     * @param string $name The name of the department to get hours for
     *
     */
    public function byName(string $name): DepartmentHours;
}
