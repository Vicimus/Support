<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\API;

use Illuminate\Contracts\Cache\Repository;
use Vicimus\Support\Exceptions\RestException;

/**
 * Trait CachesRequests
 */
trait CachesRequests
{
    /**
     * Cache repository
     *
     * @var Repository
     */
    protected $cache;

    /**
     * Bind a cache repository
     *
     * @param Repository $cache The cache repository
     *
     * @return void
     */
    public function bindCache(Repository $cache): void
    {
        $this->cache = $cache;
    }

    /**
     * Try to find a cache match
     *
     * @param string   $method  The method being used
     * @param string   $path    The path being requested
     * @param string[] $payload The payload being sent
     *
     * @return mixed|null
     */
    public function cacheMatch(string $method, string $path, array $payload)
    {
        if (!$this->cache) {
            return null;
        }

        $hash = $this->generateCacheHash($method, $path, $payload);
        $match = $this->findCacheMatch($hash);
        if (!$match) {
            return null;
        }

        if (is_string($match)) {
            return json_decode($match);
        }

        return $match;
    }

    /**
     * Overload this method with your own timeout number. This returns
     * the number of minutes a response should be cached.
     *
     * @return int
     */
    protected function cacheTime(): int
    {
        return 15;
    }

    /**
     * Clear the cache
     *
     * @param string   $method  The method used
     * @param string   $path    The path used
     * @param string[] $payload The payload sent
     *
     * @return bool
     * @throws RestException
     */
    public function clearCache(string $method, string $path, array $payload): bool
    {
        $hash = $this->generateCacheHash($method, $path, $payload);
        if (!$this->cache) {
            throw new RestException('Must bind a cache repository before clearing cache');
        }

        return $this->cache->forget($hash);
    }

    /**
     * Try to find a cache match
     *
     * @param string $hash The hash
     *
     * @return mixed
     */
    protected function findCacheMatch(string $hash)
    {
        return $this->cache->get($hash);
    }

    /**
     * Generate a hash to use as a key
     *
     * @param string   $method  The HTTP method
     * @param string   $path    The path that was requested
     * @param string[] $payload The payload of data being sent
     *
     * @return string
     */
    protected function generateCacheHash(string $method, string $path, array $payload): string
    {
        return md5(sprintf('%s:%s:%s', $path, json_encode($payload), $method));
    }
}