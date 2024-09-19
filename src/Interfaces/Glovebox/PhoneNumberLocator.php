<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface PhoneNumberLocator
{
    /**
     * Get a phone number
     */
    public function find(int $index): ?PhoneNumber;
}
