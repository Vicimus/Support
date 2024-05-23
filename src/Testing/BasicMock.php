<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use PHPUnit\Framework\MockObject\MockObject;

/**
 * Trait BasicMock
 */
trait BasicMock
{
    /**
     * Mock using basic disable constructor
     * @param string $class The class to mock
     *
     * @return MockObject|mixed
     */
    protected function basicMock(string $class): MockObject
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Mock using basic disable constructor
     * @param string $class The class to mock
     *
     * @return MockObject|mixed
     */
    protected function basic(string $class): MockObject
    {
        return $this->basicMock($class);
    }

    /**
     * Fail a test because an expected exception wasn't thrown
     *
     * @param string $exception The exception that was expected
     * @param string $method    The method we are in
     *
     * @throws InvalidArgumentException
     *
     */
    public function wasExpectingException(string $exception, string $method = ''): void
    {
        if (!$method) {
            $method = static::class;
        }

        if (class_exists($exception)) {
            $this->fail(sprintf('%s not thrown in %s', $exception, $method));
        }

        throw new InvalidArgumentException('Argument must be a valid class');
    }
}
