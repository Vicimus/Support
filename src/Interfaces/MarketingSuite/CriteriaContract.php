<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface CriteriaContract
 */
interface CriteriaContract
{
    public function payload(): array;

    public function keywords(): array;
}
