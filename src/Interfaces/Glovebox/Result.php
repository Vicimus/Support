<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Represents a result from a theme refresh
 */
interface Result
{
    /**
     * Check if the command failed or not
     */
    public function failed(): bool;

    /**
     * Get the output from the command
     *
     * @return string[][]
     */
    public function output(): array;

    /**
     * Check if the command succeeded
     */
    public function success(): bool;
}
