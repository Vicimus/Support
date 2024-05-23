<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface PhoneNumberLocator
 */
interface PhoneNumberLocator
{
    /**
     * Get a phone number
     *
     * @param int $index The index to get
     *
     */
    public function find(int $index): ?PhoneNumber;
}
