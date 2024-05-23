<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface WillValidate
 */
interface WillValidate
{
    /**
     * Get any messages from the last time isValid ran
     *
     */
    public function getValidationMessage(): ?string;

    /**
     * Validate the state of an object and return true or false
     *
     */
    public function isValid(): bool;
}
