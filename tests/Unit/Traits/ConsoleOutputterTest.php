<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Traits;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class ConsoleOutputterTest
 */
class ConsoleOutputterTest extends TestCase
{
    /**
     * Test line
     *
     * @return void
     */
    public function testLine(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('line');

        $this->assertNull($std->line('testing'));

        $std->bind($output)->line('testing');
    }

    /**
     * Test line
     *
     * @return void
     */
    public function testInfo(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('info');

        $this->assertNull($std->info('testing'));

        $std->bind($output)->info('testing');
    }

    /**
     * Test line
     *
     * @return void
     */
    public function testComment(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('comment');

        $this->assertNull($std->comment('testing'));

        $std->bind($output)->comment('testing');
    }

    /**
     * Test line
     *
     * @return void
     */
    public function testError(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('error');

        $this->assertNull($std->error('testing'));

        $std->bind($output)->error('testing');
    }

    /**
     * On bind
     *
     * @return void
     */
    public function testOnBind(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('info');

        $std->onBind(function (ConsoleOutput $output): void {
            $output->info('I\'m Bound!');
        });

        $std->bind($output);
    }
}