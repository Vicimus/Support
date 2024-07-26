<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use Illuminate\Contracts\Cache\Repository;
use Psr\SimpleCache\InvalidArgumentException;
use Vicimus\Support\Exceptions\RestException;

use function is_string;

trait CachesRequests
{
    protected ?Repository $cache;

    /**
     * Bind a cache repository
     *
     * @param Repository $cache The cache repository
     *
     */
    public function bindCache(?Repository $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * Try to find a cache match
     * @throws InvalidArgumentException
     */
    public function cacheMatch(string $method, string $path, mixed $payload, ?string $tag = null): mixed
    {
        if (!$this->cache || strtolower($method) !== 'get') {
            return null;
        }

        $hash = $this->generateCacheHash($method, $path, $payload, $tag);
        $match = $this->findCacheMatch($hash);
        if (!$match) {
            return null;
        }

        if (is_string($match)) {
            return json_decode($match, false) ?? $match;
        }

        return $match;
    }

    /**
     * Overload this method with your own timeout number. This returns
     * the number of minutes a response should be cached.
     */
    protected function cacheTime(): int
    {
        return 15 * 60;
    }

    /**
     * Clear the cache
     *
     * @param string              $method  The method used
     * @param string              $path    The path used
     * @param string[]|string[][] $payload The payload sent
     * @param string|null         $tag     Special tag to use
     *
     * @throws RestException
     */
    public function clearCache(string $method, string $path, array $payload, ?string $tag = null): bool
    {
        $hash = $this->generateCacheHash($method, $path, $payload, $tag);
        if (!$this->cache) {
            throw new RestException('Must bind a cache repository before clearing cache');
        }

        return $this->cache->forget($hash);
    }

    /**
     * Try to find a cache match
     * @throws InvalidArgumentException
     */
    protected function findCacheMatch(string $hash): mixed
    {
        return $this->cache->get($hash);
    }

    protected function generateCacheHash(string $method, string $path, mixed $payload, ?string $tag = null): string
    {
        if ($tag) {
            return md5(sprintf('%s:%s', CachesRequests::class, $tag));
        }

        return md5(sprintf('%s:%s:%s', $path, json_encode($payload), $method));
    }
}
