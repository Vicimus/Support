<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Rates;

/**
 * Provides a unifiying interface for services that provide lease and financing
 * rates
 */
interface RateProvider
{
    /**
     * Get finance and lease rates based on a styleid
     *
     * @param int $styleid The styleid to use in the lookup
     *
     * @return void
     */
    public function get(int $styleid): RateCollection;
}
