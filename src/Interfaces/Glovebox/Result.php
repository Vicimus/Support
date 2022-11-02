<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Represents a result from a theme refresh
 */
interface Result
{
    /**
     * Check if the command failed or not
     *
     * @return bool
     */
    public function failed(): bool;

    /**
     * Get the output from the command
     *
     * @return array
     */
    public function output(): bool;

    /**
     * Check if the command succeeded
     *
     * @return bool
     */
    public function success(): bool;
}
