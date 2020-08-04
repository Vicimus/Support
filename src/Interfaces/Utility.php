<?php

namespace Vicimus\Support\Interfaces;

/**
 * Represents a Utility that can be run
 *
 * @author Jordan
 */
interface Utility
{
    /**
     * The name of the utility
     *
     * @return string
     */
    public function name();

    /**
     * A description of what this utility does
     *
     * @return string
     */
    public function description();

    /**
     * Called to execute the utility
     *
     * @param string[] $flags Optional flags to add to the call.
     *
     * @return void
     */
    public function call(array $flags = null);

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     * @return mixed
     */
    public function results($payload = null);

    /**
     * Returns a confirmation prompt for the utility.
     *
     * @return string
     */
    public function prompt();
}
