<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox\Leads;

/**
 * Interface LeadPeople
 *
 * @property string $email
 */
interface LeadPerson
{
    /**
     * Convert entity into an array
     * @return mixed[]
     */
    public function toArray(): array;
}
