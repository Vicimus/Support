<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Unit\FrontEnd;

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
     * @return void
     */
    public function setup(): void
    {
        parent::setup();
        $app = new Application();
        Facade::setFacadeApplication($app);

        $app->bind('path.public', static function () {
            return __DIR__;
        });
    }

    /**
     * Test make
     *
     * @return void
     */
    public function testMake(): void
    {
        $scripts = new ScriptCache(new BasicCache(), __DIR__, 'support-tests');
        $this->assertNotNull($scripts);
    }

    /**
     * Test are unhealthy
     *
     * @return void
     */
    public function testUnhealthy(): void
    {
        $cache = new BasicCache();
        $scripts = new ScriptCache($cache, __DIR__, 'support-tests');
        $this->assertTrue($scripts->areUnhealthy());

        $cache->put(sprintf('%s-cache-%s', 'support-tests', 'en'), ['hello' => 'banana']);
        $this->assertFalse($scripts->areUnhealthy());
    }
}
