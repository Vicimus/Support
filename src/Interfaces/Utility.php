<?php declare(strict_types = 1);

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
    public function name(): string;

    /**
     * A description of what this utility does
     *
     * @return string
     */
    public function description(): string;

    /**
     * Called to execute the utility
     *
     * @return mixed
     */
    public function call();

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     * @return mixed
     */
    public function results($payload = null);
}
