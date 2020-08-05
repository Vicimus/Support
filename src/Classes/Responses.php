<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

/**
 * Class Responses
 */
class Responses
{
    /**
     * Generate a json response
     *
     * @param mixed $body The body of the response
     * @param int   $code The response code
     *
     * @return JsonResponse
     */
    public function json($body = null, int $code = 200): JsonResponse
    {
        return new JsonResponse($body, $code);
    }

    /**
     * Generate a json response
     *
     * @param mixed $body The body of the response
     * @param int   $code The response code
     *
     * @return Response
     */
    public function make($body = null, int $code = 200): Response
    {
        return new Response($body, $code);
    }
}
