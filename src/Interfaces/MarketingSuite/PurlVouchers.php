<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;

interface PurlVouchers
{
    /**
     * Download a voucher from the request
     */
    public function download(int $campaignId, Request $request): string;

    /**
     * Email a voucher to the provided email address
     */
    public function email(Request $request): bool;
}
