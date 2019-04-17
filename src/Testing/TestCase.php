<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Class TestCase
 */
abstract class TestCase extends PHPUnitTestCase
{
    use SmartAssertions;

    /**
     * Get a basic mock object
     *
     * @param string $class The class to mock
     *
     * @return MockObject|mixed
     */
    public function basicMock(string $class)
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Fail a test because an expected exception wasn't thrown
     *
     * @param string $exception The exception that was expected
     *
     * @throws InvalidArgumentException
     *
     * @return void
     */
    public function wasExpectingException(string $exception): void
    {
        if (class_exists($exception)) {
            $this->fail(sprintf('%s not thrown in %s', $exception, __METHOD__));
        }

        throw new InvalidArgumentException('Argument must be a valid class');
    }
}
