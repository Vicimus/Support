<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class Responses
{
    public function json(mixed $body = null, int $code = 200): JsonResponse
    {
        return new JsonResponse($body, $code);
    }

    public function make(mixed $body = null, int $code = 200): Response
    {
        return new Response($body, $code);
    }
}
