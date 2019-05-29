<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Throwable;
use Vicimus\Support\Classes\ConquestCompatibility;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSource;

/**
 * Class ConquestCompatibilityTest
 */
class ConquestCompatibilityTest extends TestCase
{
    /**
     * Test constructor
     *
     * @return void
     * @throws Throwable
     */
    public function testConstructor(): void
    {
        $class = $this->getMockBuilder(ConquestDataSource::class)
            ->getMock();

        $info = new ConquestCompatibility(get_class($class));
        $this->assertEquals(get_class($class), $info->class);
    }
}
