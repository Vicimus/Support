<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Testing;

use PHPUnit\Framework\MockObject\MockObject;
use Throwable;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Testing\TestCase;

/**
 * Class TestCaseTest
 */
class TestCaseTest extends TestCase
{
    /**
     * Test was expecting
     *
     * @return void
     */
    public function testWasExpecting(): void
    {
        /** @var TestCase|MockObject $test */
        $test = $this->getMockForAbstractClass(TestCase::class);

        try {
            $test->wasExpectingException(InvalidArgumentException::class);
        } catch (Throwable $ex) {
            $this->assertContains(InvalidArgumentException::class, $ex->getMessage());
        }

        try {
            $test->wasExpectingException('string');
        } catch (Throwable $ex) {
            $this->assertContains('must', $ex->getMessage());
        }
    }
}