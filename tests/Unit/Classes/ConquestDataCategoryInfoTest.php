<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Support\Collection;
use Vicimus\Support\Classes\ConquestDataCategoryInfo;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ConquestDataCategoryInfoTest
 */
class ConquestDataCategoryInfoTest extends TestCase
{
    /**
     * Test constructor
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $info = new ConquestDataCategoryInfo(
            'Banana',
            'Strawberry',
            'http://www.google.ca/img.jpg',
            self::class,
            new Collection([
                'banana', 'strawberry',
            ])
        );

        $this->assertEquals('Banana', $info->name);
        $this->assertEquals('Strawberry', $info->description);
        $this->assertEquals('http://www.google.ca/img.jpg', $info->image);
        $this->assertEquals(self::class, $info->class);
        $this->assertCount(2, $info->sources);
    }
}
