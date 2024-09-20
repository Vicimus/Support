<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Classes\Photos\AsyncPhotoRequest;
use Vicimus\Support\Classes\Photos\PhotoStatus;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

class AsyncPhotoRequestTest extends TestCase
{
    private AsyncPhotoRequest $request;

    private Photo $photo;

    private Vehicle $vehicle;

    public function setup(): void
    {
        parent::setup();

        $this->photo = $this->getMockBuilder(Photo::class)->getMock();
        $this->vehicle = $this->getMockBuilder(Vehicle::class)->getMock();

        $this->request = new AsyncPhotoRequest($this->vehicle, $this->photo);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(AsyncPhotoRequest::class, $this->request);
    }

    public function testGet(): void
    {
        $this->assertEquals($this->photo, $this->request->get('photo'));
        $this->assertNull($this->request->get('banana'));
    }

    public function testGetRequest(): void
    {
        $this->photo->expects($this->once())->method('origin');
        $request = $this->request->getRequest();
        $this->assertEquals('GET', $request->getMethod());
    }

    public function testProcess(): void
    {
        $response = new Response(200, [], '');
        $this->photo->expects($this->once())->method('status')
            ->willReturn(new PhotoStatus($this->photo, new Headers($response), $this->vehicle));
        $response = $this->request->process($response);

        $this->assertNotNull($response);
    }

    public function testNotOutdated(): void
    {
        $status = $this->getMockBuilder(PhotoStatus::class)->disableOriginalConstructor()->getMock();
        $status->method('isOutdated')->willReturn(false);

        $response = new Response(200, ['etag' => 'banana'], '');
        $this->photo->expects($this->once())->method('status')
            ->willReturn($status);
        $response = $this->request->process($response);

        $this->assertNull($response);
    }

    public function testVerb(): void
    {
        $this->request->verb('banana');
        $this->assertEquals('banana', $this->request->get('verb'));
    }
}
