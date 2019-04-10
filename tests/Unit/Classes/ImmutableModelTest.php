<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\ImmutableModel;
use Vicimus\Support\Database\Model;

/**
 * Class ImmutableModelTest
 */
class ImmutableModelTest extends TestCase
{
    /**
     * Test the constructor
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $model = $this->getMockBuilder(Model::class)->disableOriginalConstructor()->getMock();
        $immutable = new ImmutableModel(['name' => 'Name'], $model);
        $this->assertSame('Name', $immutable->name);

        $second = new ImmutableModel(['name' => 'Name']);
        $this->assertSame('Name', $second->name);
    }
}
