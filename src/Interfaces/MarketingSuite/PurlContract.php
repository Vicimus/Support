<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;
use Retention\Exceptions\PurlException;
use Retention\Exceptions\TemplateException;
use Vicimus\Onyx\Exceptions\OnyxException;
use Vicimus\Support\Interfaces\Store;

/**
 * Interface PurlContract
 */
interface PurlContract
{
    /**
     * Pinging is a way to
     *
     * @param int $campaignId The campaign id
     * @param int $customerId The customer id
     * @param int $duration   The time between pings in milliseconds
     *
     * @return void
     */
    public function ping(int $campaignId, int $customerId, int $duration): void;

    /**
     * Generate a purl response based on the request
     *
     * @param Request $request The request
     *
     * @return PurlResponse
     *
     * @throws TemplateException
     * @throws PurlException
     */
    public function response(Request $request): PurlResponse;

    /**
     * Get the store for the specified subdomain
     *
     * @param string|null $subdomain The subdomain to use in the search
     *
     * @return Store
     * @throws OnyxException
     * @throws PurlException
     */
    public function store(?string $subdomain): Store;
}
