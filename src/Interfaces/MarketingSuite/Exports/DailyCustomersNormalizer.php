<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Exports;

interface DailyCustomersNormalizer
{
    public function date(?string $value): ?string;

    public function phone(?string $phone): ?string;

    public function postal(?string $postal): ?string;
}
