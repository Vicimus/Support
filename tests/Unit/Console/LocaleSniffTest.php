<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Console;

use Illuminate\Console\OutputStyle;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\Input;
use Vicimus\Support\Console\LocaleSniff;
use Vicimus\Support\Locale\NgLocaleSniffer;

class LocaleSniffTest extends TestCase
{
    private LocaleSniff $command;

    private MockObject $sniffer;

    private Input $input;

    private OutputStyle $output;

    public function setup(): void
    {
        parent::setup();

        $this->sniffer = $this->getMockBuilder(NgLocaleSniffer::class)
            ->disableOriginalConstructor()->getMock();

        $this->input = $this->getMockBuilder(Input::class)->disableOriginalConstructor()->getMock();

        $this->output = $this->getMockBuilder(OutputStyle::class)->disableOriginalConstructor()->getMock();
        $this->command = new LocaleSniff();
        $this->command->setInput($this->input);
        $this->command->setOutput($this->output);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(LocaleSniff::class, $this->command);
    }

    public function testHandle(): void
    {
        $this->input->method('getArgument')->willReturn('locales');

        $this->sniffer->method('path')->willReturn('path');
        $this->sniffer->expects($this->once())->method('missing');

        $this->command->handle($this->sniffer);
    }
}
