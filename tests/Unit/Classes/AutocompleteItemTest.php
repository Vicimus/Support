<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\AutocompleteItem;

/**
 * Class AutocompleteItemTest
 */
class AutocompleteItemTest extends TestCase
{
    /**
     * Test making one
     */
    public function testMake(): void
    {
        $item = new AutocompleteItem('banana', 'strawberry', 'details', 'fa-user');
        $this->assertEquals('banana', $item->id);
        $this->assertEquals('strawberry', $item->name);
        $this->assertEquals('details', $item->details);
        $this->assertEquals('fa-user', $item->detailsIcon);

        $payload = $item->toArray();
        $this->assertArrayHasKey('id', $payload);
        $this->assertArrayHasKey('name', $payload);
        $this->assertArrayHasKey('details', $payload);
        $this->assertArrayHasKey('detailsIcon', $payload);
    }
}
