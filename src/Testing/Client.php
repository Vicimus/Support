<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Illuminate\Http\Request;
use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\History;
use Symfony\Component\BrowserKit\Request as DomRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Vicimus\Support\Exceptions\ValidationException;

/**
 * Class Client
 */
class Client extends HttpKernelBrowser
{
    /**
     * On request
     *
     * @var callable
     */
    private $onRequest;

    /**
     * Client constructor.
     *
     * @param callable            $onRequest On request callback
     * @param HttpKernelInterface $kernel    An instance of an http kernel
     * @param mixed[]             $server    Server vars
     * @param History|null        $history   History instance
     * @param CookieJar|null      $cookieJar Cookie jar if provided
     */
    public function __construct(
        callable $onRequest,
        HttpKernelInterface $kernel,
        array $server = [],
        ?History $history = null,
        ?CookieJar $cookieJar = null
    ) {
        $this->onRequest = $onRequest;
        $server = array_merge($server, ['HTTP_REFERER' => 'http://www.glovebox.test']);
        parent::__construct($kernel, $server, $history, $cookieJar);
    }

    /**
     * Get a response
     *
     * @noinspection PhpDocRedundantThrowsInspection
     *
     * @return Response|void
     *
     * @throws ValidationException
     *
     * phpcs:disable
     */
    public function getResponse(): Response
    {
        return parent::getResponse();
        // phpcs:enable
    }

    /**
     * Convert a BrowserKit request into a Illuminate request.
     *
     * @param DomRequest $request The request
     *
     * @return Request
     */
    protected function filterRequest(DomRequest $request): Request
    {
        $method = $this->onRequest;
        $httpRequest = $method('create', $this->getRequestParameters($request));

        $httpRequest->files->replace($this->filterFiles($httpRequest->files->all()));

        return $httpRequest;
    }

    /**
     * Get the request parameters from a BrowserKit request.
     *
     * @param DomRequest $request The request instance
     *
     * @return mixed[]
     */
    protected function getRequestParameters(DomRequest $request): array
    {
        return [
            $request->getUri(), $request->getMethod(), $request->getParameters(), $request->getCookies(),
            $request->getFiles(), $request->getServer(), $request->getContent(),
        ];
    }
}
