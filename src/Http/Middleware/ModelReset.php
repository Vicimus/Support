<?php

declare(strict_types=1);

namespace Vicimus\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Vicimus\Support\Database\Model;

class ModelReset
{
    public function handle(Request $request, Closure $next): mixed
    {
        return $next($request);
    }

    /**
     * Reset model events
     */
    public function terminate(): void
    {
        Model::resetAll();
    }
}
