<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface Hours
{
    /**
     * Get department hour info for a specific department
     */
    public function byName(string $name): DepartmentHours;
}
