<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Classes\API;

use Vicimus\Support\Classes\API\CachesRequests;
use Vicimus\Support\Testing\BasicCache;
use Vicimus\Support\Testing\TestCase;

/**
 * Class CachesRequestsTest
 */
class CachesRequestsTest extends TestCase
{
    /**
     * Instance
     * @var CachesRequests
     */
    private $instance;

    /**
     * Set up
     *
     * @return void
     * @throws \Throwable
     */
    public function setup(): void
    {
        parent::setUp();
        $this->instance = $this->getMockForTrait(CachesRequests::class);
        $cache = new BasicCache();
        $cache->set(md5(sprintf('%s:%s', CachesRequests::class, 'banana')), 'strawberry');
        $cache->set(md5(sprintf('%s:%s', CachesRequests::class, 'apple')), ['id' => 1]);
        $this->instance->bindCache($cache);
    }

    /**
     * Cache match
     *
     * @return void
     */
    public function testCacheMatch(): void
    {
        $match = $this->instance->cacheMatch('GET', '/api', ['id' => 1], 'banana');
        $this->assertEquals('strawberry', $match);
        $this->assertEquals(['id' => 1], $this->instance->cacheMatch('', '', [], 'apple'));
        $this->assertNull($this->instance->cacheMatch('', '', '', 'kiwi'));
        $this->instance->bindCache(null);
        $this->assertNull($this->instance->cacheMatch('GET', '/api', ['id' => 1]));
    }

    /**
     * Test clearing the cache
     *
     * @return void
     * @throws \Throwable
     */
    public function testClearCache(): void
    {
        $this->assertNotNull($this->instance->cacheMatch('', '', [], 'banana'));
        $this->instance->clearCache('', '', [], 'banana');
        $this->assertNull($this->instance->cacheMatch('', '', [], 'banana'));
    }
}
