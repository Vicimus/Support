<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Http\Request;
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

    /**
     * Constructor should assign properties properly from a request object
     *
     */
    public function testConstructorWithRequest(): void
    {
        $request = new Request([
            'width' => 1,
            'height' => 2,
            'scale' => 3,
            'pages' => 4,
            'letter' => false,
            'postcard' => true,
        ]);

        $render = new RenderSpecs($request);
        $this->assertEquals(1, $render->width);
        $this->assertEquals(2, $render->height);
        $this->assertEquals(3, $render->scale);
        $this->assertEquals(4, $render->pages);
        $this->assertFalse($render->letter);
        $this->assertTrue($render->postcard);
    }
}
