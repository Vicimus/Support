<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\StandardOutput;

/**
 * Class StandardOutputTest
 */
class StandardOutputTest extends TestCase
{
    /**
     * Test the comment
     *
     * @return void
     */
    public function testComment(): void
    {
        $std = new StandardOutput();

        ob_start();
        $std->comment('hello there');
        $result = ob_get_clean();

        $this->assertStringContainsString('hello there', $result);
        $this->assertStringContainsString('[1;34m', $result);
        $this->assertStringContainsString("\n", $result);
        $this->assertStringContainsString("\r", $result);
    }

    /**
     * Test the comment
     *
     * @return void
     */
    public function testError(): void
    {
        $std = new StandardOutput();

        ob_start();
        $std->error('hello there');
        $result = ob_get_clean();

        $this->assertStringContainsString('hello there', $result);
        $this->assertStringContainsString('[41m', $result);
        $this->assertStringContainsString("\n\n", $result);
        $this->assertStringContainsString("\r", $result);
    }

    /**
     * Test the info
     *
     * @return void
     */
    public function testInfo(): void
    {
        $std = new StandardOutput();

        ob_start();
        $std->info('hello there');
        $result = ob_get_clean();

        $this->assertStringContainsString('hello there', $result);
        $this->assertStringContainsString('[32m', $result);
        $this->assertStringContainsString("\n", $result);
        $this->assertStringContainsString("\r", $result);
    }

    /**
     * Test line
     *
     * @return void
     */
    public function testLine(): void
    {
        $std = new StandardOutput();

        ob_start();
        $std->line('hello there');
        $result = ob_get_clean();

        $this->assertStringContainsString('hello there', $result);
        $this->assertStringNotContainsString("\n", $result);
        $this->assertStringContainsString("\r", $result);
    }

    /**
     * Test line length
     *
     * @return void
     */
    public function testLineLength(): void
    {
        $std = new StandardOutput(120);

        ob_start();
        $std->line('hello there');
        $result = ob_get_clean();

        $this->assertEquals(120, mb_strlen($result));
    }
}
