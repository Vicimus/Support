<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\IterableArray;

/**
 * Class IterableArrayTest
 */
class IterableArrayTest extends TestCase
{
    /**
     * Make sure you can for each over this class
     *
     * @return void
     */
    public function testForEaching(): void
    {
        $array = new IterableArray([
            'one', 'two', 'three',
        ]);

        foreach ($array as $index => $item) {
            $this->assertNotNull($item);
        }
    }
}
