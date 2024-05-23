<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Incentives;

use RuntimeException;

/**
 * Residual Collection
 */
interface ResidualCollection
{
    /**
     * Get a residual value from the term period (24 mo, 60 mo, etc.)
     *
     * @param int $term The term in months
     *
     * @throws IncentiveException
     * @throws RuntimeException
     */
    public function fromTerm(int $term): ?float;
}
