<?php

namespace Vicimus\Support\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class Responses
 */
class Responses
{
    /**
     * Download a file as a response
     *
     * @param string $path The path to the file
     *
     * @return BinaryFileResponse
     */
    public function download($path)
    {
        return new BinaryFileResponse($path);
    }

    /**
     * Generate a json response
     *
     * @param mixed $body The body of the response
     * @param int   $code The response code
     *
     * @return JsonResponse
     */
    public function json($body = null, $code = 200)
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
    public function make($body = null, $code = 200)
    {
        return new Response($body, $code);
    }
}
