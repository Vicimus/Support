<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\DownloadException;
use Vicimus\Support\Classes\Photos\PhotoStatus;
use Vicimus\Support\Classes\Photos\SingleDownload;
use Vicimus\Support\Interfaces\Vehicle;

class SingleDownloadTest extends TestCase
{
    private SingleDownload $download;

    private PhotoStatus $status;

    private Vehicle $vehicle;

    public function setup(): void
    {
        parent::setup();

        $this->status = $this->getMockBuilder(PhotoStatus::class)->disableOriginalConstructor()->getMock();
        $this->vehicle = $this->getMockBuilder(Vehicle::class)->getMock();

        $this->download = new SingleDownload($this->vehicle, $this->status);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(SingleDownload::class, $this->download);
    }

    public function testGetAsyncPool(): void
    {
        $this->expectException(DownloadException::class);

        $this->download->getAsyncPool();
    }

    public function testGetSingleVehicle(): void
    {
        $this->assertEquals($this->vehicle, $this->download->getSingleVehicle());
    }

    public function testGetSinglePhoto(): void
    {
        $this->assertEquals($this->status, $this->download->getSinglePhotoStatus());
    }

    public function testIsAsync(): void
    {
        $this->assertFalse($this->download->isAsynchronous());
    }
}
