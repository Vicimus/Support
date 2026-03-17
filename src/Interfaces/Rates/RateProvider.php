<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Rates;

/**
 * Provides a unifying interface for services that provide lease and financing
 * rates
 */
interface RateProvider
{
    /**
     * Get finance and lease rates based on a style-id
     */
    public function get(int $styleid): RateCollection;
}
