<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\ProgressBar;

/**
 * Class ProgressBarTest
 */
class ProgressBarTest extends TestCase
{
    /**
     * Progress bar test
     *
     * @return void
     */
    public function testProgressBar(): void
    {
        $bar = new ProgressBar();
        $this->assertInstanceOf(ProgressBar::class, $bar);
    }
}
