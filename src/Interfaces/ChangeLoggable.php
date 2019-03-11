<?php

namespace Vicimus\Support\Interfaces;

/**
 * Interface for a models change log methods.
 */
interface ChangeLoggable
{
    /**
     * Retrieve the output for a model in the change log.
     *
     * @return string[]
     */
    public function getChangeHeader();
}
