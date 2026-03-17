<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\OnyxException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\PurlException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\TemplateException;
use Vicimus\Support\Interfaces\Store;

/**
 * Interface PurlContract
 */
interface PurlContract
{
    /**
     * Retrieve the path to the background image for a campaign
     */
    public function background(int $campaignId): string;

    /**
     * Pinging is a way to
     * @throws PurlException
     */
    public function ping(int $campaignId, int $customerId, int $duration): void;

    /**
     * Generate a purl response based on the request
     *
     * @throws TemplateException
     * @throws PurlException
     */
    public function response(Request $request): PurlResponse;

    /**
     * Get the store for the specified subdomain
     *
     * @throws OnyxException
     * @throws PurlException
     */
    public function store(?string $subdomain): Store;
}
