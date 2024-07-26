<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Console;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Console\CacheScripts;
use Vicimus\Support\FrontEnd\ScriptCache;

class CacheScriptsTest extends TestCase
{
    private CacheScripts $command;

    private MockObject $scripts;

    public function setup(): void
    {
        parent::setup();

        $this->scripts = $this->getMockBuilder(ScriptCache::class)
            ->disableOriginalConstructor()->getMock();

        $this->command = new CacheScripts($this->scripts);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(CacheScripts::class, $this->command);
    }

    public function testHandle(): void
    {
        $this->scripts->expects($this->once())->method('bind');
        $this->scripts->expects($this->once())->method('forget');
        $this->scripts->expects($this->once())->method('cache');

        $this->command->handle();
    }
}
