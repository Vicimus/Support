<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Trait GuzzleRequests
 */
trait GuzzleRequests
{
    /**
     * Get a mock guzzle client
     *
     * @param Response[]|RequestException[] $responses The responses you want
     *
     */
    protected function guzzle(array $responses = []): Client
    {
        $mock = new MockHandler($responses);

        $handler = HandlerStack::create($mock);
        return new Client(['handler' => $handler, 'base_uri' => 'http://www.banana.com']);
    }
}
