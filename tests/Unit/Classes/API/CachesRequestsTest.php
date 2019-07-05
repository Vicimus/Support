<?php declare(strict_types = 1);

namespace Vicimus\Support\Tests\Classes\API;

use Vicimus\Support\Classes\API\CachesRequests;
use Vicimus\Support\Exceptions\RestException;
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
        $anonymous = new class {
            use CachesRequests;

            /**
             * Get the cache time for testing
             * @return int
             */
            public function getCacheTime(): int
            {
                return $this->cacheTime();
            }
        };

        $this->instance = new $anonymous();
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
        $this->assertEquals(['id' => 1], $this->instance->cacheMatch('GET', '', [], 'apple'));
        $this->assertNull($this->instance->cacheMatch('GET', '', '', 'kiwi'));
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
        $this->assertNotNull($this->instance->cacheMatch('GET', '', [], 'banana'));
        $this->instance->clearCache('', '', [], 'banana');
        $this->assertNull($this->instance->cacheMatch('', '', [], 'banana'));
    }

    /**
     * Test cache time
     *
     * @return void
     */
    public function testCacheTime(): void
    {
        /** @var mixed $instance */
        $this->assertGreaterThan(0, $this->instance->getCacheTime());
    }

    /**
     * Clear cache
     *
     * @return void
     */
    public function testClearException(): void
    {
        $this->instance->bindCache(null);

        try {
            $this->instance->clearCache('', '', []);
            $this->wasExpectingException(RestException::class);
        } catch (RestException $ex) {
            $this->assertStringContainsString('bind', $ex->getMessage());
        }
    }
}
