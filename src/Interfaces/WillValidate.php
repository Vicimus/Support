<?php

namespace Vicimus\Support\Interfaces;

/**
 * Interface WillValidate
 */
interface WillValidate
{
    /**
     * Get any messages from the last time isValid ran
     *
     * @return null|string
     */
    public function getValidationMessage();

    /**
     * Validate the state of an object and return true or false
     *
     * @return bool
     */
    public function isValid();
}
