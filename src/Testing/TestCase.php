<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;

/**
 * Class TestCase
 */
abstract class TestCase extends PHPUnitTestCase
{
    use SmartAssertions;

    /**
     * Fail a test because an expected exception wasn't thrown
     *
     * @param string $exception The exception that was expected
     *
     * @return void
     */
    public function wasExpectingException(string $exception): void
    {
        $this->fail(sprintf('%s not thrown in %s', $exception, __METHOD__));
    }
}
