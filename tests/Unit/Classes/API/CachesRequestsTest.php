<?php

declare(strict_types=1);

namespace Vicimus\Support\Tests\Unit\Classes\API;

use Vicimus\Support\Classes\API\CachesRequests;
use Vicimus\Support\Exceptions\RestException;
use Vicimus\Support\Testing\BasicCache;
use Vicimus\Support\Testing\TestCase;

class CachesRequestsTest extends TestCase
{
    /**
     * @var CachesRequests
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    private $instance;

    public function setup(): void
    {
        parent::setUp();

        $anonymous = new class {
            use CachesRequests;

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

    public function testCacheMatch(): void
    {
        $match = $this->instance->cacheMatch('GET', '/api', ['id' => 1], 'banana');
        $this->assertEquals('strawberry', $match);
        $this->assertEquals(['id' => 1], $this->instance->cacheMatch('GET', '', [], 'apple'));
        $this->assertNull($this->instance->cacheMatch('GET', '', '', 'kiwi'));
        $this->instance->bindCache(null);
        $this->assertNull($this->instance->cacheMatch('GET', '/api', ['id' => 1]));
    }

    public function testClearCache(): void
    {
        $this->assertNotNull($this->instance->cacheMatch('GET', '', [], 'banana'));
        $this->instance->clearCache('', '', [], 'banana');
        $this->assertNull($this->instance->cacheMatch('', '', [], 'banana'));
    }

    public function testCacheTime(): void
    {
        $this->assertGreaterThan(0, $this->instance->getCacheTime());
    }

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
