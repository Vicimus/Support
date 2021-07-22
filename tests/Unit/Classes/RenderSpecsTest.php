<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Vicimus\Support\Classes\RenderSpecs;
use Vicimus\Support\Testing\TestCase;

/**
 * Class RenderSpecsTest
 */
class RenderSpecsTest extends TestCase
{
    /**
     * Constructor should assign properties properly
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $render = new RenderSpecs(1, 2, 3, 4, false, true);
        $this->assertEquals(1, $render->width);
        $this->assertEquals(2, $render->height);
        $this->assertEquals(3, $render->scale);
        $this->assertEquals(4, $render->pages);
        $this->assertFalse($render->letter);
        $this->assertTrue($render->postcard);
    }
}
