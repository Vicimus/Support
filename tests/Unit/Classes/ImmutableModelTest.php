<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use stdClass;
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
     */
    public function testConstructor(): void
    {
        $model = new class extends Model{
            //
        };
        $model->name = 'Model Name';

        $this->assertSame('Model Name', $model->name);

        $immutableModel = new class extends ImmutableModel{
            /**
             * Get attributes
             * @return string[]
             */
            protected function attributes(): array
            {
                return ['name'];
            }
        };

        $instance = new $immutableModel(['name' => null], $model);
        $this->assertNull($instance->name);

        $instance = new $immutableModel([], $model);
        $this->assertSame('Model Name', $instance->name);

        $class = new stdClass();
        $class->name = 'Class Name';

        $instance = new $immutableModel($class, $model);
        $this->assertSame('Class Name', $instance->name);

        try {
            new ImmutableModel('banana');
            $this->fail('Immutable Banana created');
        } catch (InvalidArgumentException $ex) {
            $this->assertStringContainsString('array or object', $ex->getMessage());
        }
    }
}
