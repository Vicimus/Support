<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Enums;

/**
 * Class ToolsTest
 *
 * @package Vicimus\Support\Tests\Unit
 */
class EnumsTest extends TestCase
{
    /**
     * Test states function.
     *
     * @return void
     */
    public function testStates(): void
    {
        $provinces = Enums::states('CA');
        $this->assertArrayHasKey('QC', $provinces);

        $states = Enums::states('US');
        $this->assertArrayHasKey('NY', $states);

        $all = Enums::states();
        $this->assertArrayHasKey('CA', $all);

        $nothing = Enums::states('invalid country code');
        $this->assertNull($nothing);
    }
}
