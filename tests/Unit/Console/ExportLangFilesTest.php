<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Console;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stringable;
use Symfony\Component\Console\Input\Input;
use Vicimus\Support\Console\ExportLangFiles;
use Vicimus\Support\Locale\LangGenerator;

class ExportLangFilesTest extends TestCase
{
    private ExportLangFiles $command;

    private MockObject $generator;

    private Input $input;

    public function setup(): void
    {
        parent::setup();

        $this->generator = $this->getMockBuilder(LangGenerator::class)
            ->disableOriginalConstructor()->getMock();

        $fakePaths = new class implements Stringable {
            public function __toString(): string
            {
                return 'banana';
            }
        };

        app()->bind('path.storage', static fn () => new $fakePaths());
        app()->bind('path.resource', static fn () => new $fakePaths());
        $this->input = $this->getMockBuilder(Input::class)->disableOriginalConstructor()->getMock();

        $this->command = new ExportLangFiles();
        $this->command->setInput($this->input);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(ExportLangFiles::class, $this->command);
    }

    public function testHandle(): void
    {
        $this->input->method('getArgument')
            ->willReturnOnConsecutiveCalls('target', 'locale');

        $this->generator->expects($this->once())->method('bind')->willReturnSelf();
        $this->generator->expects($this->once())->method('export');

        $this->command->handle($this->generator);
    }

    public function testHandleWithoutTargetIsFine(): void
    {
        $this->input->method('getArgument')
            ->willReturnOnConsecutiveCalls('', 'locale', 'locale');

        $this->generator->expects($this->once())->method('bind')->willReturnSelf();
        $this->generator->expects($this->once())->method('export');

        $this->command->handle($this->generator);
    }
}
