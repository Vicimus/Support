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
}
