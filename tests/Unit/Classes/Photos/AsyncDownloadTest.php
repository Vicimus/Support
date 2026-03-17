<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Classes\Photos\AsyncDownload;
use Vicimus\Support\Classes\Photos\DownloadException;

class AsyncDownloadTest extends TestCase
{
    private AsyncDownload $download;

    private AsyncRequestPool $pool;

    public function setup(): void
    {
        parent::setup();

        $this->pool = new AsyncRequestPool();

        $this->download = new AsyncDownload($this->pool);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(AsyncDownload::class, $this->download);
    }

    public function testPool(): void
    {
        $this->assertEquals($this->pool, $this->download->getAsyncPool());
    }

    public function testSinglePhotoStatus(): void
    {
        $this->expectException(DownloadException::class);
        $this->download->getSinglePhotoStatus();
    }

    public function testSingleVehicle(): void
    {
        $this->expectException(DownloadException::class);
        $this->download->getSingleVehicle();
    }

    public function testAsync(): void
    {
        $this->assertTrue($this->download->isAsynchronous());
    }
}
