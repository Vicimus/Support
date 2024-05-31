<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;

/**
 * Interface PurlVouchers
 */
interface PurlVouchers
{
    /**
     * Download a voucher from the request
     *
     * @param int     $campaignId The id of campaign the voucher belongs to
     * @param Request $request    The request object
     *
     */
    public function download(int $campaignId, Request $request): string;

    /**
     * Email a voucher to the provided email address
     *
     * @param Request $request The request object
     *
     */
    public function email(Request $request): bool;
}
