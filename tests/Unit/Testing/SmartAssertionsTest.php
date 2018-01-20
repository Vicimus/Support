<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\Testing;

use Illuminate\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Throwable;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Testing\SmartAssertions;
use Vicimus\Support\Testing\TestCase;

/**
 * Class SmartAssertionsTest
 */
class SmartAssertionsTest extends TestCase
{
    /**
     * Test
     *
     * @return void
     */
    public function testResponseOk(): void
    {
        /** @var TestCase|SmartAssertions|MockObject $test */
        $test = $this->getMockForAbstractClass(TestCase::class);

        $this->assertNotNull($test->assertStatusOk(new Response(json_encode(['id' => 1]), 200)));

        $result = '';

        try {
            $test->assertStatusOk(new Response(json_encode(['error' => 'bad news']), 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertContains('bad news', $result);

        try {
            $test->assertStatusOk(new Response(json_encode([
                'error' => 'invalid',
                'type' => InvalidArgumentException::class,
            ]), 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertContains('invalid', $result);

        try {
            $test->assertStatusOk(new Response(json_encode([
                'error' => 'invalid',
                'type' => InvalidArgumentException::class,
                'file' => __FILE__,
                'line' => 666,
            ]), 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertContains(__FILE__, $result);
        $this->assertContains('666', $result);

        try {
            $test->assertStatusOk(new Response('hi', 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertContains('hi', $result);

        try {
            $test->assertStatusOk(new Response(['id' => 1], 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertContains(json_encode(['id' => 1]), $result);
    }

    public function testFiltering(): void
    {
        /** @var TestCase|SmartAssertions|MockObject $test */
        $test = $this->getMockForAbstractClass(TestCase::class);

        $test->filterFilePath(function (string $file): string {
            return str_replace('banana', 'strawberry', $file);
        });

        $result = '';

        try {
            $test->assertStatusOk(new Response(json_encode([
                'error' => 'invalid',
                'type' => InvalidArgumentException::class,
                'file' => 'banana',
                'line' => 666,
            ]), 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertContains('strawberry', $result);
    }
}
