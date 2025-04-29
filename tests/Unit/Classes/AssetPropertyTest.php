<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\AssetProperty;
use Vicimus\Support\Interfaces\PropertyRecord;
use Vicimus\Support\Testing\GuzzleTestCase;

class AssetPropertyTest extends GuzzleTestCase
{
    /**
     * Assert non-hidden properties are on the toArray payload
     */
    public function testPayload(): void
    {
        $asset = new AssetProperty(['property' => 'title', 'value' => 'My Title']);

        $payload = $asset->toPayload();
        $this->assertArrayHasKey('property', $payload);
        $this->assertSame($payload['property'], 'title');

        $this->assertArrayHasKey('value', $payload);
        $this->assertSame($payload['value'], 'My Title');
    }

    /**
     * Assert property methods are implemented
     */
    public function testPropertyImplementation(): void
    {
        $asset = new AssetProperty([
            'property' => 'budget',
            'value' => 1,
            'restrictions' => 'numeric',
            'values' => [1, 2],
            'datatype' => 'int',
            'input' => 'select',
        ]);

        $this->assertSame('budget', $asset->property());
        $this->assertSame('numeric', $asset->restrictions());
        $this->assertSame('int', $asset->type());
        $this->assertSame(1, $asset->value());
        $this->assertSame('select', $asset->input());
    }

    /**
     * If you don't provide a key it should automatically figure it out
     */
    public function testValuesKeyParsing(): void
    {
        $property = new AssetProperty([
            'property' => 'test',
            'value' => 'banana',
            'restrictions' => null,
            'values' => [
                'one' => 'strawberry',
                'Banana',
                'A More Complicated One',
            ],
        ]);

        $values = $property->values();
        $this->assertArrayHasKey('banana', $values);
        $this->assertArrayHasKey('one', $values);
        $this->assertArrayHasKey('a_more_complicated_one', $values);
    }

    /**
     * Assert retrieving display
     */
    public function testDisplay(): void
    {
        $property = new AssetProperty([
            'display' => 'Testing',
            'property' => 'test',
        ]);

        $this->assertSame('Testing', $property->display());
    }

    /**
     * Assert populate
     */
    public function testPopulate(): void
    {
        $record = $this->createMock(PropertyRecord::class);
        $record->method('getId')->willReturn(1);
        $record->method('getValue')->willReturn('banana');

        $property = new AssetProperty([]);
        $property->populate($record);

        $this->assertSame('banana', $property->value);
        $this->assertSame(1, $property->id);
    }

    /**
     * Assert setting values property
     */
    public function testValues(): void
    {
        $property = new AssetProperty([]);
        $property->values(['one', 'two', 'number three']);

        $this->assertCount(3, $property->values());
    }

    public function testConstructorCasts(): void
    {
        $property = new AssetProperty(['values' => '[]']);
        $this->assertEmpty($property->values);
    }
}
