<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\DownloadProgress;
use Vicimus\Support\Interfaces\ConsoleOutput;

class DownloadProgressTest extends TestCase
{
    private DownloadProgress $download;

    public function setup(): void
    {
        parent::setup();

        $this->download = new DownloadProgress(20);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(DownloadProgress::class, $this->download);
    }

    public function testBytes(): void
    {
        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(3))->method('line');

        $this->download->bind($output);
        $this->download->bytes(2);
        $this->download->bytes(2);
        $this->download->bytes(2);
    }

    public function testIncError(): void
    {
        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(1))->method('line');

        $this->download->bind($output);
        $this->download->incError();
    }

    public function testIncSuccess(): void
    {
        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(1))->method('line');

        $this->download->bind($output);
        $this->download->incSuccess();
    }

    public function testOutput(): void
    {
        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(1))->method('line');

        $this->download->bind($output);
        $this->download->output();
    }

    public function testAutoIncrement(): void
    {
        $this->download = new DownloadProgress(0);
        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(1))->method('line');

        $this->download->bind($output);
        $this->download->output();
    }
}
