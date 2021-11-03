<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use Vicimus\Support\Database\Model;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ModelTest
 */
class ModelTest extends TestCase
{
    /**
     * Test delete
     *
     * @return void
     */
    public function testDelete(): void
    {
        $model = new Model();
        $this->assertNull($model->delete());
    }

    /**
     * @return void
     */
    public function testSetAttributeWithNoCasts(): void
    {
        $testing = new class extends Model {
            /**
             * @var string[]
             */
            protected $casts = ['id' => 'int'];
        };

        $testing::withoutCasts();

        $instance = new $testing();
        $instance->id = '1';

        $this->assertSame('1', $instance->id);
    }
}
