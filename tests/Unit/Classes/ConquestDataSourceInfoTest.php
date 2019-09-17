<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\ConquestCompatibilityMatrix;
use Vicimus\Support\Classes\ConquestDataSourceInfo;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ConquestDataCategoryInfoTest
 */
class ConquestDataSourceInfoTest extends TestCase
{
    /**
     * Test constructor
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $info = new ConquestDataSourceInfo(
            'Banana',
            'Strawberry',
            self::class,
            self::class,
            new ConquestCompatibilityMatrix([
                'banana' => 'strawberry',
            ]),
            ['facebook_carousel'],
            'fa-facebook'
        );

        $this->assertEquals('Banana', $info->name);
        $this->assertEquals('Strawberry', $info->description);
        $this->assertEquals(self::class, $info->category);
        $this->assertEquals(self::class, $info->class);
        $this->assertNotNull($info->matrix);
        $this->assertCount(1, $info->mediums);
    }
}
