<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Represents a Utility that can be run
 */
interface Utility
{
    /**
     * Called to execute the utility
     *
     * @param string[] $flags Optional flags to add to the call.
     *
     */
    public function call(?array $flags = null): mixed;

    /**
     * A description of what this utility does
     *
     */
    public function description(): string;

    /**
     * The name of the utility
     *
     */
    public function name(): string;

    /**
     * Returns a confirmation prompt for the utility.
     *
     */
    public function prompt(): string;

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     */
    public function results($payload = null): mixed;
}
