<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Rates;

/**
 * Provides a unified interface for the results of RateProviders
 */
interface RateCollection
{
    /**
     * Get all available finance rates. This method must return an array
     * of Rate instances.
     *
     * @return Rate[]
     */
    public function finances(): array;

    /**
     * Get the rate for a specific term in financing rates
     *
     * @param int $term The term for the financing
     *
     * @return float
     */
    public function finance(int $term): ?float;

    /**
     * Get all available lease rates
     *
     * @return Rate[]
     */
    public function leases(): array;

    /**
     * Get the rate for a specific term in lease rates. This method must
     * return an array of Rate instances.
     *
     * @param int $term The term for the lease
     *
     * @return float
     */
    public function lease(int $term): ?float;

    /**
     * Get all available rates, both finance and leases. This method MUST return
     * an array of Rate instances.
     *
     * @return Rate[]
     */
    public function all(): array;
}
