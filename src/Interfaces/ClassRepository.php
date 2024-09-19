<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface ClassRepository
{
    public function isRegistered(string $source): bool;

    /**
     * @param string|string[] $classes Register one or many data sources
     */
    public function register(string | array $classes): void;
}
