<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface DataSource
{
    /**
     * Handle a data point request
     *
     * @param string   $point      The point requested
     * @param string[] $userParams The parameters to pass along
     */
    public function handle(string $point, array $userParams = []): mixed;

    public function name(): string;

    /**
     * @return string[]|array
     */
    public function points(): array;

    public function slug(): string;
}
