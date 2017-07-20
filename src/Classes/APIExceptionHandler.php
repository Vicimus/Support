<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Throwable;

/**
 * Class APIExceptionHandler
 */
class APIExceptionHandler
{
    /**
     * Render an exception into an HTTP response.
     *
     * @param Request   $request   The request object
     * @param Throwable $exception The exception to render
     *
     * @return mixed
     *
     * @codingStandardsIgnoreStart
     */
    public function handle(Request $request, Throwable $exception)
    {
        $class = get_class($exception);
        if ($class == ModelNotFoundException::class) {
            return response()->json([
                'error' => 'The requested resource could not be found ('.
                    $request->path().')',
            ], 404);
        }

        return response()->json([
            'error' => $exception->getMessage(),
            'type'  => get_class($exception),
            'line'  => $exception->getLine(),
            'file'  => $exception->getFile(),
        ], 500);
    }

}
