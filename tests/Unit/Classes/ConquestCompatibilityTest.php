<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\ConquestCompatibility;
use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Interfaces\MarketingSuite\ConquestDataSource;

class ConquestCompatibilityTest extends TestCase
{
    public function testConstructor(): void
    {
        $class = $this->getMockBuilder(ConquestDataSource::class)
            ->getMock();

        $info = new ConquestCompatibility($class::class);
        $this->assertEquals($class::class, $info->class);
    }

    public function testConstructorInvalid(): void
    {
        $class = ImmutableObject::class;

        try {
            new ConquestCompatibility($class);
            $this->fail('Was expecting exception');
        } catch (InvalidArgumentException $ex) {
            $this->assertStringContainsString(ConquestDataSource::class, $ex->getMessage());
        }
    }
}
