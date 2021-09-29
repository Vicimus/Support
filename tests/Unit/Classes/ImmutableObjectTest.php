<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;
use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use stdClass;
use Throwable;
use Vicimus\Support\Classes\ImmutableObject;
use Vicimus\Support\Exceptions\ImmutableObjectException;

/**
 * Class ImmutableObjectTest
 */
class ImmutableObjectTest extends TestCase
{
    /**
     * Test the constructor
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $std = new stdClass();
        $std->id = 5;

        $obj = new ImmutableObject(['id' => 5]);
        $second = new ImmutableObject($std);

        $this->assertEquals(5, $obj->id);
        $this->assertEquals(5, $second->id);

        try {
            new ImmutableObject('string');
            $this->fail('Exception not thrown');
        } catch (InvalidArgumentException $ex) {
            $this->assertStringContainsString('array', $ex->getMessage());
        }
    }

    /**
     * Test toString
     *
     * @return void
     */
    public function testToString(): void
    {
        $obj = new ImmutableObject(['id' => 5]);
        $array = ['id' => 5];

        $this->assertEquals((string) $obj, json_encode($array));
    }

    /**
     * Validation
     *
     * @return void
     */
    public function testValidation(): void
    {
        $errors = '';
        /** @var Factory|MockObject $factory */
        $factory = $this->getMockBuilder(Factory::class)
            ->getMock();

        $validator = $this->getMockBuilder(Validator::class)
            ->getMock();

        $validator->method('fails')
            ->willReturn(false);

        $validator->method('errors')
            ->willReturn(new MessageBag());

        $factory->method('make')
            ->willReturn($validator);

        $obj = new ImmutableObject(['id' => 5], $factory);
        try {
            $this->assertTrue($obj->isValid());
        } catch (Throwable $ex) {
            $this->fail((string) $ex);
        }

        try {
            $errors = $obj->getValidationMessage();
        } catch (Throwable $ex) {
            $this->fail((string) $ex);
        }

        $this->assertIsString($errors);
    }

    /**
     * Must bind a factory
     *
     * @return void
     */
    public function testValidationNoneSet(): void
    {
        $obj = new ImmutableObject(['id' => 5]);
        try {
            $obj->isValid();
            $this->fail('Was expecting ' . ImmutableObjectException::class);
        } catch (ImmutableObjectException $ex) {
            $this->assertStringContainsString('isValid', $ex->getMessage());
        }

        try {
            $obj->getValidationMessage();
            $this->fail('Was expecting ' . ImmutableObjectException::class);
        } catch (ImmutableObjectException $ex) {
            $this->assertStringContainsString('without', $ex->getMessage());
        }
    }

    /**
     * Test casting
     *
     * @return void
     */
    public function testCasting(): void
    {
        /* phpcs:disable */
        $extension = new class extends ImmutableObject {
            /** @var string[] Casts */
            protected $casts = [
                'id' => 'int',
                'other' => ImmutableObject::class,
            ];
        };
        /* phpcs:enable */

        $instance = new $extension([
            'id' => 1,
            'fruit' => 'kiwi',
            'other' => [
                'banana' => 'strawberry',
            ],
        ]);

        $this->assertSame(1, $instance->id);
        $this->assertEquals('strawberry', $instance->other->banana);
        $this->assertEquals('kiwi', $instance->fruit);
    }

    /**
     * Recursive Arrays
     *
     * @return void
     */
    public function testRecursiveArrays(): void
    {
        $instance = new ImmutableObject([
            'object' => new ImmutableObject(['hi' => 'there']),
            'children' => [
                new ImmutableObject([
                    'banana' => 'strawberry',
                    'apples' => [1, 2, 3],
                    'grand-children' => [
                        new ImmutableObject(),
                    ],
                    'food' => [
                        'fruit' => ['apple'],
                    ],
                ]),
            ],
            'banana' => 'strawberry',
            'strawberry' => [
                1, 2, 3,
            ],
        ]);

        $result = $instance->toArray();
        $this->assertIsArray($result);
        $this->assertIsArray($result['children']);
        $this->assertIsArray($result['children'][0]);
        $this->assertIsArray($result['children'][0]['grand-children']);
        $this->assertIsArray($result['children'][0]['grand-children'][0]);
    }

    /**
     * It's really dumb that you need comments
     * @return void
     */
    public function testArrayAccess(): void
    {
        $instance = new ImmutableObject(['banana' => 'strawberry']);
        $this->assertEquals('strawberry', $instance['banana']);
        $this->assertTrue(isset($instance['banana']));
    }
}
