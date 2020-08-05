<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Database;

use Illuminate\Support\Collection;
use InvalidArgumentException;
use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Database\ModelFactoryBuilder;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ModelFactoryBuilderTest
 */
class ModelFactoryBuilderTest extends TestCase
{
    /**
     * Test create
     * @return void
     */
    public function testCreate(): void
    {
        $model = new class extends ImmutableObject {
            /**
             * Call static
             *
             * @param string         $name      The name of the method
             * @param string[]|array $arguments The arguments
             *
             * @return ImmutableObject|__anonymous@427
             *
             * @throws InvalidArgumentException
             */
            public static function __callStatic(string $name, array $arguments)
            {
                if ($name === 'create') {
                    return new self($arguments[0]);
                }

                throw new InvalidArgumentException('Invalid method');
            }
        };

        $builder = new ModelFactoryBuilder(static function () {
            return ['kiwi' => 'apple'];
        }, get_class($model), 1);

        $result = $builder->create(['banana' => 'strawberry']);
        $this->assertEquals('strawberry', $result->banana);
        $this->assertEquals('apple', $result->kiwi);

        $builder = new ModelFactoryBuilder(static function () {
            return ['kiwi' => 'apple'];
        }, get_class($model), 3);

        $results = $builder->create(['banana' => 'strawberry']);
        $results->each(function (ImmutableObject $item): void {
            $this->assertEquals('strawberry', $item->banana);
            $this->assertEquals('apple', $item->kiwi);
        });
    }

    /**
     * Test create
     * @return void
     */
    public function testMake(): void
    {
        $model = new class extends ImmutableObject {
            /**
             * Call static
             *
             * @param string         $name      The name of the method
             * @param string[]|array $arguments The arguments
             *
             * @return ImmutableObject|__anonymous@427
             *
             * @throws InvalidArgumentException
             */
            public static function __callStatic(string $name, array $arguments)
            {
                if ($name === 'make') {
                    return new self($arguments[0]);
                }

                throw new InvalidArgumentException('Invalid method');
            }
        };

        $builder = new ModelFactoryBuilder(static function () {
            return ['kiwi' => 'apple'];
        }, get_class($model), 1);

        $result = $builder->make(['banana' => 'strawberry']);
        $this->assertEquals('strawberry', $result->banana);
        $this->assertEquals('apple', $result->kiwi);

        $builder = new ModelFactoryBuilder(static function () {
            return ['kiwi' => 'apple'];
        }, get_class($model), 3);

        $results = new Collection($builder->make(['banana' => 'strawberry']));
        $results->each(function (ImmutableObject $item): void {
            $this->assertEquals('strawberry', $item->banana);
            $this->assertEquals('apple', $item->kiwi);
        });
    }
}
