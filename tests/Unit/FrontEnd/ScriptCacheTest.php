<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\FrontEnd;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\Facades\Facade;
use Vicimus\Support\FrontEnd\ScriptCache;
use Vicimus\Support\Testing\Application;
use Vicimus\Support\Testing\BasicCache;
use Vicimus\Support\Testing\TestCase;

/**
 * Class ScriptCacheTest
 */
class ScriptCacheTest extends TestCase
{
    /**
     * Setup
     *
     */
    public function setup(): void
    {
        parent::setUp();

        $app = new Application();
        Facade::setFacadeApplication($app);

        $app->bind('path.public', static fn () => __DIR__ . '/../../../resources/testing');

        $app->bind('url', static fn () => new UrlGenerator(new RouteCollection(), new Request()));
    }

    /**
     * Test make
     *
     */
    public function testMake(): void
    {
        $scripts = new ScriptCache(
            new BasicCache(),
            __DIR__ . '/../../../resources/testing/front-end',
            'support-tests'
        );
        $this->assertNotNull($scripts);
    }

    /**
     * Test are unhealthy
     *
     */
    public function testUnhealthy(): void
    {
        $cache = new BasicCache();
        $scripts = new ScriptCache(
            $cache,
            __DIR__ . '/../../../resources/testing/front-end',
            'support-tests'
        );
        $this->assertTrue($scripts->areUnhealthy());

        $cache->put(sprintf('%s-cache-%s', 'support-tests', 'en'), ['hello' => 'banana']);
        $this->assertFalse($scripts->areUnhealthy());
    }

    /**
     * Test cache
     *
     */
    public function testCache(): void
    {
        $cache = $this->basicMock(BasicCache::class);
        $cache->expects($this->once())
            ->method('forever');

        $cache->expects($this->once())
            ->method('forget');

        $scripts = new ScriptCache(
            $cache,
            __DIR__ . '/../../../resources/testing/front-end',
            'support-tests'
        );

        $scripts->cache();

        $scripts->forget();
    }
}
