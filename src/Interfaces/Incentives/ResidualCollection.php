<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Incentives;

use RuntimeException;

interface ResidualCollection
{
    /**
     * Get a residual value from the term period (24 mo, 60 mo, etc.)
     *
     * @throws IncentiveException
     * @throws RuntimeException
     */
    public function fromTerm(int $term): ?float;
}
