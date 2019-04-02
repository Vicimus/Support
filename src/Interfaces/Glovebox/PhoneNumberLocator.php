<?php

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
     * @return PhoneNumber|null
     */
    public function find($index);
}
