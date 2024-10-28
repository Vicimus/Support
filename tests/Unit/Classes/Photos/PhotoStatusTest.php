<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Classes\Photos\PhotoStatus;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;

class PhotoStatusTest extends TestCase
{
    private PhotoStatus $status;

    private Headers $headers;

    private Photo $photo;

    private Vehicle $vehicle;

    public function setup(): void
    {
        parent::setup();

        $this->headers = $this->getMockBuilder(Headers::class)->disableOriginalConstructor()->getMock();
        $this->photo = $this->getMockBuilder(Photo::class)->getMock();
        $this->vehicle = $this->getMockBuilder(Vehicle::class)->getMock();

        $this->status = new PhotoStatus($this->photo, $this->headers, $this->vehicle);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(PhotoStatus::class, $this->status);
    }

    public function testGet(): void
    {
        $this->assertEquals($this->photo, $this->status->photo);
    }

    public function testDownload(): void
    {
        $download = $this->status->download();
        $this->assertEquals($this->vehicle, $download->vehicle());
        $this->assertEquals($this->status, $download->status());
    }

    public function testOutdated(): void
    {
        $this->assertTrue($this->status->isOutdated());
        $this->headers->method('get')->willReturn('banana');
        $this->photo->method('etag')->willReturn('banana');

        $this->assertFalse($this->status->isOutdated());
    }
}
