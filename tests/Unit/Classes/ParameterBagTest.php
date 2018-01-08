<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\ParameterBag;

/**
 * Class ParameterBagTest
 */
class ParameterBagTest extends TestCase
{
    /**
     * Renaming removes the original property and assigns it to a new one
     *
     * @return void
     */
    public function testRename(): void
    {
        $bag = new ParameterBag([
            'banana' => 'strawberry',
        ]);

        $this->assertTrue($bag->has('banana'));
        $this->assertEquals('strawberry', $bag->get('banana'));

        $bag->rename('banana', 'apple');

        $this->assertFalse($bag->has('banana'));
        $this->assertNull($bag->get('banana'));

        $this->assertTrue($bag->has('apple'));
        $this->assertEquals('strawberry', $bag->get('apple'));
    }

    /**
     * Parameter Bag
     *
     * @return void
     */
    public function testGrab(): void
    {
        $bag = new ParameterBag([
            'banana' => 'strawberry',
        ]);

        $this->assertTrue($bag->has('banana'));
        $value = $bag->grab('banana');

        $this->assertFalse($bag->has('banana'));
        $this->assertEquals('strawberry', $value);
    }

    /**
     * Test put
     *
     * @return void
     */
    public function testPut(): void
    {
        $bag = new ParameterBag([
            'banana' => 'strawberry',
        ]);

        $this->assertEquals('strawberry', $bag->get('banana'));
        $bag->put('banana', 'apple');
        $this->assertEquals('apple', $bag->get('banana'));
    }

    /**
     * Treat it like an array
     *
     * @return void
     */
    public function testArrayAccess(): void
    {
        $bag = new ParameterBag([
            'banana' => 'strawberry',
        ]);

        $this->assertEquals('strawberry', $bag['banana']);

        if ($bag['banana']) {
            $bag['banana'] = 'apples';
        }

        $this->assertEquals('apples', $bag->get('banana'));
        unset($bag['banana']);
        $this->assertFalse($bag->has('banana'));
        $this->assertTrue(empty($bag['banana']));
    }

    /**
     * Test checksumming bags
     *
     * @return void
     */
    public function testChecksum(): void
    {
        $first = new ParameterBag([
            'banana' => 'strawberry',
        ]);

        $second = new ParameterBag([
            'banana' => 'strawberry',
        ]);

        $original = $first->checksum();

        $this->assertEquals($first->checksum(), $second->checksum());

        $first->put('banana', 'apple');
        $this->assertNotEquals($original, $first->checksum());

        $first->put('banana', 'strawberry');
        $this->assertEquals($original, $first->checksum());
    }
}
