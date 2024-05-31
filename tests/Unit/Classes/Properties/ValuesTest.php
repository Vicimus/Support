<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\Properties\Values;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\PropertyProvider;
use Vicimus\Support\Interfaces\Property;
use Vicimus\Support\Interfaces\PropertyRecord;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ValuesTest
 */
class ValuesTest extends TestCase
{
    /**
     * Assert values are found
     */
    public function testValues(): void
    {
        $provider = $this->basicMock(PropertyProvider::class);
        $property = $this->basicMock(PropertyRecord::class);
        $property->method('name')->willReturn('title');

        $service = new Values();
        $values = $service->values($provider, $property);
        $this->assertEmpty($values);

        $another = $this->basicMock(Property::class);
        $another->method('property')->willReturn('another');

        $providerProp = $this->basicMock(Property::class);
        $providerProp->method('property')->willReturn('title');
        $providerProp->method('values')->willReturn([1, 2]);

        $provider->method('properties')->willReturn([$another, $providerProp]);

        $values = $service->values($provider, $property);
        $this->assertCount(2, $values);
    }
}
