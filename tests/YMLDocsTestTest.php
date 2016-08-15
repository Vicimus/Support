<?php

namespace Vicimus\Support\Tests;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\YMLDocs\YMLDocsTest;

/**
 * Test that the YMLDocsTest can be instantiated
 *
 * @author Jordan Grieve <jgrieve@vicimus.com>
 */
class YMLDocsTestTest extends TestCase
{
    /**
     * Ensure it can be constructed
     *
     * @return void
     */
    public function testInstantiate()
    {
        $test = new YMLDocsTest;
        $this->assertInstanceOf(YMLDocsTest::class, $test);
    }
}
