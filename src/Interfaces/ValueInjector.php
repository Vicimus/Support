<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

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
