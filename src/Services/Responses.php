<?php declare(strict_types = 1);

namespace Vicimus\Support\Services;

use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

/**
 * Class Responses
 */
class Responses
{
    /**
     * The view factory
     * @var Factory
     */
    private $view;

    /**
     * Responses constructor.
     *
     * @param Factory $view The view factory
     */
    public function __construct(Factory $view)
    {
        $this->view = $view;
    }

    /**
     * Download a file as a response
     *
     * @param string $path The path to the file
     *
     * @return BinaryFileResponse
     */
    public function download(string $path): BinaryFileResponse
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

    /**
     * Create a new response for a given view.
     *
     * @param string  $view    The view to load
     * @param mixed[] $data    The data to pass
     * @param int     $status  The status
     * @param mixed[] $headers Any headers
     *
     * @return Response
     */
    public function view(string $view, array $data = [], int $status = 200, array $headers = []): Response
    {
        return new Response($this->view->make($view, $data), $status, $headers);
    }
}
