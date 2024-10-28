<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface ChangeLoggable
{
    /**
     * Retrieve the output for a model in the change log.
     * @return string[]
     */
    public function getChangeHeader(): array;
}
