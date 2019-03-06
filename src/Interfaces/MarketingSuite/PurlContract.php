<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;

/**
 * Interface PurlContract
 */
interface PurlContract
{
    /**
     * Generate a purl response based on the request
     *
     * @param Request $request The request
     *
     * @return PurlResponse
     */
    public function response(Request $request): PurlResponse;
}
