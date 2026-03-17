<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Console;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Stringable;
use Symfony\Component\Console\Input\Input;
use Vicimus\Support\Console\GenerateLangFiles;
use Vicimus\Support\Locale\LangGenerator;

class GenerateLangFilesTest extends TestCase
{
    private GenerateLangFiles $command;

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

        app()->bind('path.app', static fn () => new $fakePaths());
        app()->bind('path.storage', static fn () => new $fakePaths());
        app()->bind('path.resource', static fn () => new $fakePaths());
        $this->input = $this->getMockBuilder(Input::class)->disableOriginalConstructor()->getMock();

        $this->command = new GenerateLangFiles();
        $this->command->setInput($this->input);
    }

    public function testHandle(): void
    {
        $this->input->method('getArgument')->willReturn('locales');

        $this->generator->method('bind')->willReturnSelf();
        $this->generator->expects($this->exactly(2))->method('fire');

        $this->command->handle($this->generator);
    }
}
