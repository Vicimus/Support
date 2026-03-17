<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\ProcessProgress;
use Vicimus\Support\Interfaces\ConsoleOutput;

class ProcessProgressTest extends TestCase
{
    private ProcessProgress $progress;

    private ConsoleOutput $output;

    public function setup(): void
    {
        parent::setup();
        $this->output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $this->progress = new ProcessProgress(20);
        $this->progress->bind($this->output);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(ProcessProgress::class, $this->progress);
    }

    public function testCreated(): void
    {
        $this->output->expects($this->once())->method('line');
        $this->progress->created();
    }

    public function testPersist(): void
    {
        $this->output->expects($this->once())->method('info');
        $this->progress->persist('info');
    }

    public function testSkipped(): void
    {
        $this->output->expects($this->once())->method('line');
        $this->progress->skipped();
    }

    public function testUpdated(): void
    {
        $this->output->expects($this->once())->method('line');
        $this->progress->updated();
    }

    public function testError(): void
    {
        $this->output->expects($this->once())->method('line');
        $this->progress->incError();
    }

    public function testAutoIncrement(): void
    {
        $this->output->expects($this->once())->method('line');

        $this->progress = new ProcessProgress(0);
        $this->progress->bind($this->output);

        $this->progress->output();
    }
}
