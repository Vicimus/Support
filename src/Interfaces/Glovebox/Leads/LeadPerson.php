<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * @property string $email
 */
interface LeadPerson
{
    /**
     * Convert entity into an array
     * @return string[][]
     */
    public function toArray(): array;
}
