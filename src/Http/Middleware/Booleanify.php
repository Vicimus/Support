<?php

declare(strict_types=1);

namespace Vicimus\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Booleanify
{
    /**
     * Handle an incoming request.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @return mixed
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.ReturnTypeHint
     */
    public function handle(Request $request, Closure $next)
    {
        $input = $request->all();
        foreach ($input as $property => $value) {
            if ($value === 'true') {
                $input[$property] = true;
            }

            if ($value !== 'false') {
                continue;
            }

            $input[$property] = false;
        }

        $request->replace($input);
        return $next($request);
    }
}
