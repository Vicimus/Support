<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes;

use Laravel\Lumen\Routing\Router;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Vicimus\Support\Classes\LumenRouter;

/**
 * Class LumenRouterTest
 */
class LumenRouterTest extends TestCase
{
    /**
     * The router we'll be testing
     *
     */
    protected LumenRouter $router;

    /**
     * Test delete
     *
     */
    public function testDelete(): void
    {
        /** @var Router|MockObject $app */
        $app = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['delete'])
            ->getMock();

        $app->expects($this->once())
            ->method('delete')
            ->will($this->returnSelf());

        $this->router = new LumenRouter($app);
        $this->router->delete('/api/delete', 'test@test');
    }

    /**
     * Test delete
     *
     */
    public function testPost(): void
    {
        /** @var Router|MockObject $app */
        $app = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['post'])
            ->getMock();

        $app->expects($this->once())
            ->method('post')
            ->will($this->returnSelf());

        $this->router = new LumenRouter($app);
        $this->router->post('/api/post', 'test@test');
    }

    /**
     * Test delete
     *
     */
    public function testPatch(): void
    {
        /** @var Router|MockObject $app */
        $app = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['patch'])
            ->getMock();

        $app->expects($this->once())
            ->method('patch')
            ->will($this->returnSelf());

        $this->router = new LumenRouter($app);
        $this->router->patch('/api/patch', 'test@test');
    }

    /**
     * Test delete
     *
     */
    public function testGet(): void
    {
        /** @var Router|MockObject $app */
        $app = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();

        $app->expects($this->once())
            ->method('get')
            ->will($this->returnSelf());

        $this->router = new LumenRouter($app);
        $this->router->get('/api/get', 'test@test');
    }

    /**
     * Test the resource route
     *
     */
    public function testResource(): void
    {
        /* Plural */
        /** @var Router|MockObject $app */
        $app = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'patch', 'post', 'delete'])
            ->getMock();

        $app->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnSelf());

        $app->expects($this->once())
            ->method('patch')
            ->will($this->returnSelf());

        $app->expects($this->once())
            ->method('post')
            ->will($this->returnSelf());

        $app->expects($this->once())
            ->method('delete')
            ->will($this->returnSelf());

        $this->router = new LumenRouter($app);
        $this->router->resource('bananas', 'BananaController');

        /* Non-Plural */
        /** @var Router|MockObject $app */
        $app = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->setMethods(['get', 'patch', 'post', 'delete'])
            ->getMock();

        $app->expects($this->exactly(2))
            ->method('get')
            ->will($this->returnSelf());

        $app->expects($this->once())
            ->method('patch')
            ->will($this->returnSelf());

        $app->expects($this->once())
            ->method('post')
            ->will($this->returnSelf());

        $app->expects($this->once())
            ->method('delete')
            ->will($this->returnSelf());

        $this->router = new LumenRouter($app);
        $this->router->resource('banana', 'BananaController');
    }
}
