<?php

declare(strict_types=1);

namespace Vicimus\Support\Services;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class Responses
{
    public function __construct(
        private readonly Factory $view,
    ) {
        //
    }

    public function download(string $path): BinaryFileResponse
    {
        return new BinaryFileResponse($path);
    }

    public function json(mixed $body = null, int $code = 200): JsonResponse
    {
        return new JsonResponse($body, $code);
    }

    public function make(mixed $body = null, int $code = 200): Response
    {
        return new Response($body, $code);
    }

    /**
     * Create a new response for a given view.
     *
     * @param string     $view    The view to load
     * @param string[][] $data    The data to pass
     * @param int        $status  The status
     * @param string[][] $headers Any headers
     */
    public function view(string $view, array $data = [], int $status = 200, array $headers = []): Response
    {
        return new Response($this->view->make($view, $data), $status, $headers);
    }
}
