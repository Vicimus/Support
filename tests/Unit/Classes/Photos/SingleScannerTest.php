<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\PhotoStatus;
use Vicimus\Support\Classes\Photos\SingleScanner;
use Vicimus\Support\Exceptions\PhotoException;
use Vicimus\Support\Exceptions\UnauthorizedPhotoException;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

class SingleScannerTest extends TestCase
{
    private SingleScanner $scanner;

    private Photo $photo;

    private Vehicle $vehicle;

    public function setup(): void
    {
        parent::setup();

        $this->photo = $this->getMockBuilder(Photo::class)->getMock();
        $this->vehicle = $this->getMockBuilder(Vehicle::class)->getMock();

        $this->scanner = new SingleScanner($this->vehicle, $this->photo);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(SingleScanner::class, $this->scanner);
    }

    public function testScan(): void
    {
        $mock = new MockHandler([
            new Response(200, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->photo->method('origin')->willReturn('banana');

        $result = $this->scanner->scan($client);

        $this->assertInstanceOf(PhotoStatus::class, $result);
    }

    public function testScanError422(): void
    {
        $this->expectException(PhotoException::class);

        $mock = new MockHandler([
            new Response(422, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->photo->method('origin')->willReturn('banana');

        $this->scanner->scan($client);
    }

    public function testScanError401(): void
    {
        $this->expectException(UnauthorizedPhotoException::class);

        $mock = new MockHandler([
            new Response(401, [], ''),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $this->photo->method('origin')->willReturn('banana');

        $this->scanner->scan($client);
    }
}
