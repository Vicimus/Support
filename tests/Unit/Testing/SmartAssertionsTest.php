<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Testing;

use Illuminate\Http\Response;
use PHPUnit\Framework\MockObject\MockObject;
use Throwable;
use Vicimus\Support\Exceptions\InvalidArgumentException;
use Vicimus\Support\Testing\SmartAssertions;
use Vicimus\Support\Testing\TestCase;

class SmartAssertionsTest extends TestCase
{
    public function testResponseOk(): void
    {
        /** @var TestCase|SmartAssertions|MockObject $test */
        $test = $this->getMockBuilder(TestCase::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $this->assertNotNull($test->assertStatusOk(new Response(json_encode(['id' => 1]), 200)));

        $result = '';

        try {
            $test->assertStatusOk(new Response(json_encode(['error' => 'bad news']), 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertStringContainsString('bad news', $result);

        try {
            $test->assertStatusOk(new Response(json_encode([
                'error' => 'invalid',
                'type' => InvalidArgumentException::class,
            ]), 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertStringContainsString('invalid', $result);

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

        $this->assertStringContainsString(__FILE__, $result);
        $this->assertStringContainsString('666', $result);

        try {
            $test->assertStatusOk(new Response('hi', 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertStringContainsString('hi', $result);

        try {
            $test->assertStatusOk(new Response(['id' => 1], 500));
        } catch (Throwable $ex) {
            $result = $ex->getMessage();
        }

        $this->assertStringContainsString(json_encode(['id' => 1]), $result);
    }

    public function testFiltering(): void
    {
        /** @var TestCase|SmartAssertions|MockObject $test */
        $test = $this->getMockBuilder(TestCase::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $test->filterFilePath(static fn (string $file): string => str_replace('banana', 'strawberry', $file));

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

        $this->assertStringContainsString('strawberry', $result);
    }
}
