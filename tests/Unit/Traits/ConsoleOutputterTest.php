<?php

declare(strict_types=1);

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

        $std->onBind(static function (ConsoleOutput $output): void {
            $output->info('I\'m Bound!');
        });

        $std->bind($output);
    }

    /**
     * Pre-formatted text containing "%" is printed verbatim, not used as a
     * format string (PHP 8 throws ValueError for an unmatched directive)
     */
    public function testTextWithPercentSignAndNoArgumentsIsPrintedVerbatim(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('line')
            ->with('Scanning: 5/10 50% (1.2MB)');

        $output->expects($this->once())
            ->method('error')
            ->with('Could not fetch https://example.com/photo%20one.jpg');

        $std->bind($output);
        $std->line('Scanning: 5/10 50% (1.2MB)');
        $std->error('Could not fetch https://example.com/photo%20one.jpg');
    }

    /**
     * Arguments are still substituted into the format string
     */
    public function testArgumentsAreFormatted(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('info')
            ->with('Scanning: 5/10 50% (1.2MB)');

        $std->bind($output)->info('Scanning: %s/%s %s%% (%s)', 5, 10, 50, '1.2MB');
    }

    /**
     * A format string with too few arguments falls back to the raw text
     * instead of throwing
     */
    public function testMismatchedArgumentsFallBackToRawText(): void
    {
        /** @var ConsoleOutputter|MockObject $std */
        $std = $this->getMockForTrait(ConsoleOutputter::class);

        /** @var ConsoleOutput|MockObject $output */
        $output = $this->getMockBuilder(ConsoleOutput::class)
            ->getMock();

        $output->expects($this->once())
            ->method('comment')
            ->with('%s of %s done');

        $std->bind($output)->comment('%s of %s done', 1);
    }
}
