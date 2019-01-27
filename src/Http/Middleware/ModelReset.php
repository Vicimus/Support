<?php declare(strict_types = 1);

namespace Vicimus\Support\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Vicimus\Support\Database\Model;

/**
 * Class ModelReset
 */
class ModelReset
{
    /**
     * Do nothing
     *
     * @param Request $request The request instance
     * @param Closure $next    The next middleware in the stack
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    /**
     * Reset model events
     *
     * @return void
     */
    public function terminate()
    {
        Model::resetAll();
    }
}
