<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use InvalidArgumentException;
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
     * @throws Throwable
     */
    public function testConstructor(): void
    {
        $class = $this->getMockBuilder(ConquestDataSource::class)
            ->getMock();

        $info = new ConquestCompatibility($class::class);
        $this->assertEquals($class::class, $info->class);
    }

    /**
     * Test failure
     *
     */
    public function testConstructorInvalid(): void
    {
        $class = self::class;

        try {
            new ConquestCompatibility($class);
            $this->fail('Was expecting exception');
        } catch (InvalidArgumentException $ex) {
            $this->assertStringContainsString(ConquestDataSource::class, $ex->getMessage());
        }
    }
}
