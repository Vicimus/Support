<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Vicimus\Support\Exceptions\RestException;

class APIExceptionHandler
{
    public function handle(Request $request, Throwable $exception): JsonResponse
    {
        $class = $exception::class;
        if ($class === ModelNotFoundException::class) {
            return response()->json([
                'error' => 'The requested resource could not be found (' .
                    $request->path() . ')',
            ], 404);
        }

        $code = 500;
        if ($exception instanceof RestException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], $exception->code);
        }

        if ($exception instanceof NotFoundHttpException) {
            $code = 404;
        }

        return response()->json([
            'error' => $exception->getMessage(),
            'type'  => $exception::class,
            'line'  => $exception->getLine(),
            'file'  => $exception->getFile(),
        ], $code);
    }
}
