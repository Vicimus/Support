<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use InvalidArgumentException;
use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Database\ModelFactory;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ModelFactoryTest
 */
class ModelFactoryTest extends TestCase
{
    /**
     * Builder
     * @return void
     */
    public function testBuilderUndefined(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $factory = new ModelFactory();
        $factory->builder(ImmutableObject::class);
    }

    /**
     * Test builder
     * @return void
     */
    public function testBuilder(): void
    {
        $factory = new ModelFactory();
        $factory->define(ImmutableObject::class, static function () {
            return [];
        });

        $builder = $factory->builder(ImmutableObject::class);
        $this->assertNotNull($builder);
    }
}
