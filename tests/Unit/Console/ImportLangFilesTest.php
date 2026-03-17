<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Console;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\Input;
use Vicimus\Support\Console\ImportLangFiles;
use Vicimus\Support\Locale\LangGenerator;

class ImportLangFilesTest extends TestCase
{
    private ImportLangFiles $command;

    private MockObject $generator;

    private Input $input;

    public function setup(): void
    {
        parent::setup();

        $this->generator = $this->getMockBuilder(LangGenerator::class)
            ->disableOriginalConstructor()->getMock();

        $this->input = $this->getMockBuilder(Input::class)->disableOriginalConstructor()->getMock();

        $this->command = new ImportLangFiles();
        $this->command->setInput($this->input);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(ImportLangFiles::class, $this->command);
    }

    public function testHandle(): void
    {
        $this->input->method('getArgument')->willReturn('locales');

        $this->generator->method('bind')->willReturnSelf();
        $this->generator->expects($this->once())->method('import');

        $this->command->handle($this->generator);
    }
}
