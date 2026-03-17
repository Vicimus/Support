<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Classes\Photos\AsyncPhotoRequest;
use Vicimus\Support\Classes\Photos\AsyncScanner;
use Vicimus\Support\Classes\Photos\PhotoStatus;
use Vicimus\Support\Interfaces\Photo;

class AsyncScannerTest extends TestCase
{
    private AsyncScanner $scanner;

    private AsyncRequestPool $pool;

    public function setup(): void
    {
        parent::setup();

        $this->pool = $this->getMockBuilder(AsyncRequestPool::class)->disableOriginalConstructor()->getMock();

        $this->scanner = new AsyncScanner($this->pool);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(AsyncScanner::class, $this->scanner);
    }

    public function testScan(): void
    {
        $this->pool->method('requests')->willReturn($this->mockGenerator([
            new Request('GET', 'banana'),
            new Request('GET', 'strawberry'),
        ]));

        $mock = new MockHandler([
            new Response(200, [], ''),
            new Response(200, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $request = $this->getMockBuilder(AsyncPhotoRequest::class)->disableOriginalConstructor()->getMock();
        $status = $this->getMockBuilder(PhotoStatus::class)->disableOriginalConstructor()->getMock();
        $request->method('process')->willReturnOnConsecutiveCalls($status, null);

        $this->pool->method('at')->willReturn($request);

        $results = $this->scanner->scan($client);

        $this->assertCount(1, $results);
    }

    public function testScanWithFailure(): void
    {
        $this->pool->method('requests')->willReturn($this->mockGenerator([
            new Request('GET', 'banana'),
        ]));

        $mock = new MockHandler([
            new Response(404, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $request = $this->getMockBuilder(AsyncPhotoRequest::class)->disableOriginalConstructor()->getMock();
        $status = $this->getMockBuilder(PhotoStatus::class)->disableOriginalConstructor()->getMock();
        $request->method('process')->willReturn($status);
        $photo = $this->getMockBuilder(Photo::class)->getMock();
        $photo->expects($this->once())->method('update');
        $request->method('get')->willReturn($photo);

        $this->pool->method('at')->willReturn($request);

        $results = $this->scanner->scan($client);

        $this->assertCount(0, $results);
    }

    /**
     * @param Request[] $values
     */
    private function mockGenerator(array $values): Generator
    {
        foreach ($values as $value) {
            yield $value;
        }
    }
}
