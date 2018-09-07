<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Illuminate\Contracts\Validation\Factory;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;
use InvalidArgumentException;
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
            $this->assertContains('array', $ex->getMessage());
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

        $this->assertEquals($obj->__toString(), json_encode($array));
    }

    /**
     * Validation
     *
     * @return void
     */
    public function testValidation(): void
    {
        $errors = '';
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
            $this->fail($ex->__toString());
        }

        try {
            $errors = $obj->getValidationMessage();
        } catch (Throwable $ex) {
            $this->fail($ex->__toString());
        }

        $this->assertInternalType('string', $errors);
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
            $this->assertContains('isValid', $ex->getMessage());
        }

        try {
            $obj->getValidationMessage();
            $this->fail('Was expecting ' . ImmutableObjectException::class);
        } catch (ImmutableObjectException $ex) {
            $this->assertContains('without', $ex->getMessage());
        }
    }
}
