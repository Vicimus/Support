<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;
use Illuminate\View\View;

interface PurlScripts
{
    /**
     * Handle the purl scripts
     */
    public function handle(Request $request): View;
}
