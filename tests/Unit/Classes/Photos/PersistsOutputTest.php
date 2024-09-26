<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\PersistsOutput;
use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class PersistsOutputTest extends TestCase
{
    /**
     * @var PersistsOutput
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $instance;

    public function setup(): void
    {
        parent::setup();

        $this->instance = new class
        {
            use ConsoleOutputter;
            use PersistsOutput;

            protected string $previous = 'banana';
        };
    }

    public function testMake(): void
    {
        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(1))->method('comment');
        $this->instance->bind($output);

        $this->assertContains(PersistsOutput::class, class_uses($this->instance));

        $this->instance->persist();
    }

    public function testWillNotCrashIfNoPrevious(): void
    {
        $this->instance = new class
        {
            use ConsoleOutputter;
            use PersistsOutput;
        };

        $output = $this->getMockBuilder(ConsoleOutput::class)->getMock();
        $output->expects($this->exactly(0))->method('comment');
        $this->instance->bind($output);
        $this->instance->persist();
    }
}
