<?php

namespace Vicimus\Support\Services;

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
    public function json($body, $code = 200)
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
    public function make($body, $code = 200)
    {
        return new Response($body, $code);
    }
}
