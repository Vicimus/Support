<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use InvalidArgumentException;
use PHPUnit\Framework\MockObject\MockObject;

trait BasicMock
{
    /**
     * Mock using basic disable constructor
     */
    protected function basicMock(string $class): MockObject
    {
        return $this->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * Mock using basic disable constructor
     */
    protected function basic(string $class): MockObject
    {
        return $this->basicMock($class);
    }

    /**
     * Fail a test because an expected exception wasn't thrown
     *
     * @throws InvalidArgumentException
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
