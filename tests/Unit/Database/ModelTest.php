<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Database;

use Vicimus\Support\Database\Model;
use Vicimus\Support\Testing\TestCase;

class ModelTest extends TestCase
{
    public function testDelete(): void
    {
        $model = new Model();
        $this->assertNull($model->delete());
    }

    public function testSetAttributeWithNoCasts(): void
    {
        $testing = new class extends Model {
            /**
             * @var string[]
             * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
             */
            protected $casts = ['id' => 'int'];
        };

        $testing::withoutCasts();

        $instance = new $testing();
        $instance->id = '1';

        $this->assertSame('1', $instance->id);
    }
}
