<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Grouping;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Interfaces\MarketingSuite\Campaign;
use Vicimus\Support\Interfaces\Property;

/**
 * Class GroupingTest
 */
class GroupingTest extends TestCase
{
    /**
     * Asset grouping validates it's properties
     */
    public function testGroupingThrows(): void
    {
        try {
            new Grouping([], ['property1']);
            $this->fail('InvalidArgumentException not thrown');
        } catch (InvalidArgumentException $ex) {
            $this->assertStringContainsString(sprintf('expected %s', Property::class), $ex->getMessage());
        }
    }

    /**
     * Assert Grouping constructor
     */
    public function testGrouping(): void
    {
        $property = $this->getMockBuilder(Property::class)->disableOriginalConstructor()->getMock();

        $grouping = new Grouping(['test1', 'test2'], [$property]);
        $this->assertCount(2, $grouping->items);
        $this->assertCount(1, $grouping->properties);
    }

    /**
     * Assert retrieving a property from a grouping
     */
    public function testProperty(): void
    {
        $property = $this->getMockBuilder(Property::class)->disableOriginalConstructor()->getMock();
        $property->method('property')->willReturn('test_prop');
        $property->method('value')->willReturn('test value');
        $grouping = new Grouping([], [$property]);

        $prop = $grouping->property('test_prop');
        $this->assertNotNull($prop);
        $this->assertSame('test value', $prop->value());
    }

    /**
     * Assert retrieving a property from a grouping
     */
    public function testNotOwnedProperty(): void
    {
        $property = $this->getMockBuilder(Property::class)->disableOriginalConstructor()->getMock();
        $property->method('property')->willReturn('test_prop');
        $grouping = new Grouping([], [$property]);

        $prop = $grouping->property('test_prop2');
        $this->assertNull($prop);
    }

    /**
     * On Update exists
     *
     */
    public function testOnUpdate(): void
    {
        /** @var Campaign|MockObject $campaign */
        $campaign = $this->getMockBuilder(Campaign::class)->getMock();
        $payload = [];

        $grouping = new Grouping();
        $grouping->onUpdate($campaign, $payload);

        $this->assertNotNull($grouping);
    }
}
