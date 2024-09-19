<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\Photos;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Photos\ScannerProgress;

class ScannerProgressTest extends TestCase
{
    private ScannerProgress $progress;

    public function setup(): void
    {
        parent::setup();

        $this->progress = new ScannerProgress(20);
    }

    public function testMake(): void
    {
        $this->assertInstanceOf(ScannerProgress::class, $this->progress);
    }
}
