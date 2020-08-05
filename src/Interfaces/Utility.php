<?php declare(strict_types = 1);

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
     * @return mixed
     */
    public function call(?array $flags = null);

    /**
     * A description of what this utility does
     *
     * @return string
     */
    public function description(): string;

    /**
     * The name of the utility
     *
     * @return string
     */
    public function name(): string;

    /**
     * Returns a confirmation prompt for the utility.
     *
     * @return string
     */
    public function prompt(): string;

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     * @return mixed
     */
    public function results($payload = null);
}
