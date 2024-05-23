<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Interface to use to inject values into an array
 */
interface ValueInjector
{
    /**
     * Inject any values into the input array
     *
     * @param string[] $input The input values to inspect and add to
     *
     * @return string[]
     */
    public function handle(array $input): array;
}
