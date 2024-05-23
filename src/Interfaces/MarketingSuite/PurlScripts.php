<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Interface PurlScripts
 */
interface PurlScripts
{
    /**
     * Handle the purl scripts
     *
     * @param Request $request The request object
     *
     */
    public function handle(Request $request): View;
}
