<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\Download;
use Vicimus\Support\Classes\Photos\PhotoStatus;
use Vicimus\Support\Interfaces\Vehicle;

class DownloadTest extends TestCase
{
    private Download $download;

    private PhotoStatus $status;

    private Vehicle $vehicle;

    public function setup(): void
    {
        parent::setup();

        $this->status = $this->getMockBuilder(PhotoStatus::class)->disableOriginalConstructor()->getMock();
        $this->vehicle = $this->getMockBuilder(Vehicle::class)->getMock();

        $this->download = new Download($this->vehicle, $this->status);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(Download::class, $this->download);
    }

    public function testStatus(): void
    {
        $this->assertEquals($this->status, $this->download->status());
    }

    public function testVehicle(): void
    {
        $this->assertEquals($this->vehicle, $this->download->vehicle());
    }
}
