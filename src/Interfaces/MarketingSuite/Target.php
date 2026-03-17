<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface Target
{
    /**
     * Convert the target into an array
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed[][]
     */
    public function toArray(): array;
}
