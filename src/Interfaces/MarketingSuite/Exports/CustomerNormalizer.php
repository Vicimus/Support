<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Exports;

interface CustomerNormalizer
{
    public function date(?string $value): ?string;

    public function phone(?string $phone): ?string;

    public function postal(?string $postal): ?string;
}
