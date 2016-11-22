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
     * @return void
     */
    public function call();

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     * @return void
     */
    public function results($payload = null);
}
