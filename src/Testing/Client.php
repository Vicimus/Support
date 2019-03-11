<?php

namespace Vicimus\Support\Testing;

use Symfony\Component\BrowserKit\CookieJar;
use Symfony\Component\BrowserKit\History;
use Symfony\Component\HttpKernel\Client as BaseClient;
use Symfony\Component\BrowserKit\Request as DomRequest;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Client
 */
class Client extends BaseClient {
    /**
     * On request
     *
     * @var callable
     */
    private $onRequest;

    public function __construct(callable $onRequest, HttpKernelInterface $kernel, array $server = [], History $history = null, CookieJar $cookieJar = null)
    {
        $this->onRequest = $onRequest;
        parent::__construct($kernel, $server, $history, $cookieJar);
    }

    /**
     * Convert a BrowserKit request into a Illuminate request.
     *
     * @param  \Symfony\Component\BrowserKit\Request  $request
     * @return \Illuminate\Http\Request
     */
    protected function filterRequest(DomRequest $request)
    {
        $method = $this->onRequest;
        $httpRequest = $method('create', $this->getRequestParameters($request));

        $httpRequest->files->replace($this->filterFiles($httpRequest->files->all()));

        return $httpRequest;
    }

    /**
     * Get the request parameters from a BrowserKit request.
     *
     * @param  \Symfony\Component\BrowserKit\Request  $request
     * @return array
     */
    protected function getRequestParameters(DomRequest $request)
    {
        return array(
            $request->getUri(), $request->getMethod(), $request->getParameters(), $request->getCookies(),
            $request->getFiles(), $request->getServer(), $request->getContent()
        );
    }

}
