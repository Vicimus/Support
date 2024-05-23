<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\API;

use Vicimus\Support\Classes\API\AsyncRequest;
use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Testing\TestCase;

/**
 * Class AsyncRequestPoolTest
 */
class AsyncRequestPoolTest extends TestCase
{
    /**
     * The pool
     */
    private AsyncRequestPool $pool;

    /**
     * Set the test up
     *
     */
    public function setup(): void
    {
        parent::setUp();
        $this->pool = new AsyncRequestPool('GET');
    }

    /**
     * Test add
     *
     */
    public function testAdd(): void
    {
        $request = $this->basicMock(AsyncRequest::class);
        $request->expects($this->once())
            ->method('verb');

        $request->expects($this->once())
            ->method('getRequest');

        $this->pool->add($request);

        $this->assertSame($request, $this->pool->at(0));
        $this->assertSame(1, $this->pool->total());

        foreach ($this->pool->requests() as $yielded) {
            $this->assertNotNull($yielded);
        }
    }

    /**
     * Test the counter
     *
     */
    public function testCounter(): void
    {
        $this->assertSame(1, $this->pool->counter());
        $this->assertSame(2, $this->pool->counter());
        $this->assertSame(3, $this->pool->counter());
    }
}
