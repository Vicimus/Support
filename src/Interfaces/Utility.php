<?php

namespace Vicimus\Support\Interfaces\Utility;

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
}
