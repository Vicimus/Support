<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use Illuminate\Http\Request;
use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\History;
use Symfony\Component\BrowserKit\Request as DomRequest;
use Symfony\Component\HttpKernel\HttpKernelBrowser;
use Symfony\Component\HttpKernel\HttpKernelInterface;

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
     * @param string[]            $server    Server vars
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
     * Convert a BrowserKit request into a Illuminate request.
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
     * @return string[][]
     */
    protected function getRequestParameters(DomRequest $request): array
    {
        return [
            $request->getUri(), $request->getMethod(), $request->getParameters(), $request->getCookies(),
            $request->getFiles(), $request->getServer(), $request->getContent(),
        ];
    }
}
