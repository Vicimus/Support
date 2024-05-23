<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use GuzzleHttp\Psr7\Response;
use stdClass;
use Vicimus\Support\Classes\API\MultipartPayload;
use Vicimus\Support\Classes\APIService;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Testing\GuzzleTestCase;

/**
 * Class APIServiceTest
 */
class APIServiceTest extends GuzzleTestCase
{
    /**
     * Test basic request
     *
     * @throws \Throwable
     *
     */
    public function testRequest(): void
    {
        $api = new APIService($this->guzzle([
            new Response(200, [], json_encode(['id' => 1])),
        ]), 'banana.com');

        $response = $api->request('get', '');
        $this->assertNotNull($response);
    }

    /**
     * Test basic request
     *
     * @throws \Throwable
     *
     */
    public function testMultiPart(): void
    {
        $api = new APIService($this->guzzle([
            new Response(200, [], json_encode(['id' => 1])),
        ]), 'banana.com');

        $response = $api->multipart('get', [
            new MultipartPayload('banana', 'strawberry'),
        ]);

        $this->assertNotNull($response);
    }

    /**
     * Test basic request
     *
     * @throws \Throwable
     *
     */
    public function testRequestException(): void
    {
        $api = new APIService($this->guzzle([
            new Response(500, [], json_encode(['error' => 'bad stuff'])),
        ]), 'banana.com');

        try {
            $api->request('get', '');
            $this->wasExpectingException(RestException::class);
        } catch (RestException $ex) {
            $this->assertEquals(500, $ex->getCode());
            $this->assertStringContainsString('bad stuff', $ex->getMessage());
        }
    }

    /**
     * Test basic request
     *
     * @throws \Throwable
     *
     */
    public function testMultiPartPatch(): void
    {
        $api = new APIService($this->guzzle([
            new Response(200, [], json_encode(['id' => 1])),
        ]), 'banana.com');

        $response = $api->multipart('banana', [
            new MultipartPayload('banana', 'strawberry'),
        ], 'PATCH');

        $this->assertNotNull($response);
    }

    /**
     * Test basic request
     *
     * @throws \Throwable
     *
     */
    public function testMultiPartExceptions(): void
    {
        $api = new APIService($this->guzzle([
            new Response(422, [], json_encode(['error' => 'you are bad'])),
            new Response(500, [], json_encode(['error' => 'i am bad'])),
        ]), 'banana.com');

        try {
            $api->multipart('get', [
                new MultipartPayload('banana', 'strawberry'),
            ]);
            $this->wasExpectingException(RestException::class);
        } catch (RestException $ex) {
            $this->assertStringContainsString('you are bad', $ex->getMessage());
            $this->assertEquals(422, $ex->getCode());
        }

        try {
            $api->multipart('get', [
                new MultipartPayload('banana', 'strawberry'),
            ]);
            $this->wasExpectingException(RestException::class);
        } catch (RestException $ex) {
            $this->assertStringContainsString('i am bad', $ex->getMessage());
            $this->assertEquals(500, $ex->getCode());
        }

        try {
            $api->multipart('get', [
                new MultipartPayload('banana', 'strawberry'),
                new stdClass(),
            ]);
            $this->wasExpectingException(InvalidArgumentException::class);
        } catch (InvalidArgumentException $ex) {
            $this->assertStringContainsString(MultipartPayload::class, $ex->getMessage());
            $this->assertEquals(500, $ex->getCode());
        }
    }

    /**
     * Test varations on request
     *
     * @throws RestException
     *
     */
    public function testRequestVariations(): void
    {
        $api = new APIService($this->guzzle([
            new Response(200, [], json_encode(['id' => 1])),
            new Response(200, [], json_encode(['id' => 1])),
            new Response(422, [], json_encode(['error' => 'you are bad'])),
            new Response(500, [], json_encode(['error' => 'i am bad'])),
        ]), 'banana.com');

        $this->assertNotNull($api->request('post', 'api', null));
        $this->assertNotNull($api->request('POST', 'api', new stdClass()));
    }
}
