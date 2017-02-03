<?php

namespace Vicimus\Support\Interfaces;

/**
 * Interface to use to inject values into an array
 */
interface ValueInjector
{
    /**
     * Inject any values into the input array
     *
     * @param array $input The input values to inspect and add to
     *
     * @return array
     */
    public function handle(array $input) : array;
}
