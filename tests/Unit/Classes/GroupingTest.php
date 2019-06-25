<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\Grouping;

/**
 * Class GroupingTest
 */
class GroupingTest extends TestCase
{
    /**
     * Assert Grouping constructor
     * @return void
     */
    public function testGrouping(): void
    {
        $grouping = new Grouping(['test1', 'test2'], ['property1']);
        $this->assertCount(2, $grouping->items);
        $this->assertCount(1, $grouping->properties);
    }
}
