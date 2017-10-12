<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface WillValidate
 *
 * @package Vicimus\Support\Interfaces
 */
interface WillValidate
{
    /**
     * Get any messages from the last time isValid ran
     *
     * @return null|string
     */
    public function getValidationMessage(): ?string;

    /**
     * Validate the state of an object and return true or false
     *
     * @return bool
     */
    public function isValid(): bool;
}
