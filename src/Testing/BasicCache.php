<?php

/* phpcs:disable */
/*
 * This is phpcs disabled because I'm lazy, sue me.
 * Tons of it would fail sniffing and not be able to be fixed to meet Laravel's
 * interface, so every single method would be multiple phpcs suppress comments
 * and none of it would matter anyway.
 */

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use Closure;
use Illuminate\Contracts\Cache\Repository;

class BasicCache implements Repository
{
    /**
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @var mixed[]
     */
    protected array $cache = [];

    /**
     * BasicCache constructor.
     *
     * @param string[] $initial Set the initial cache
     */
    public function __construct(array $initial = [])
    {
        $this->cache = $initial;
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string|mixed                               $key     The key
     * @param  mixed                                      $value   The value
     * @param  \DateTimeInterface|\DateInterval|float|int $minutes The minutes
     *
     * @return bool|mixed
     */
    public function add($key, $value, $minutes = null)
    {
        // TODO: Implement add() method
    }

    /**
     * Wipes clean the entire cache's keys.
     */
    public function clear(): bool
    {
        $this->cache = [];
        return true;
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string|mixed $key   The key
     * @param  mixed        $value The value
     *
     * @return int|bool|mixed
     */
    public function decrement($key, $value = 1)
    {
        // TODO: Implement decrement() method.
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string|mixed $key The unique cache key of the item to delete.
     *
     * @return bool|mixed True if the item was successfully removed. False if there was an error.
     */
    public function delete($key): bool
    {
        unset($this->cache[$key]);
        return true;
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param mixed $keys A list of string-based keys to be deleted.
     *
     * @return bool|mixed True if the items were successfully removed. False if there was an error.
     */
    public function deleteMultiple($keys): bool
    {
        // TODO: Implement deleteMultiple() method.
        return true;
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string|mixed $key   The key
     * @param  mixed        $value The value
     *
     * @return void|mixed
     */
    public function forever($key, $value)
    {
        // TODO: Implement forever() method.
    }

    /**
     * Remove an item from the cache.
     *
     * @param string|mixed $key The key
     *
     * @return bool|mixed
     */
    public function forget($key)
    {
        unset($this->cache[$key]);
        return !array_key_exists($key, $this->cache);
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|mixed $key     The key to get
     * @param  mixed        $default The default to return
     *
     * @return mixed
     */
    public function get($key, mixed $default = null): mixed
    {
        return $this->cache[$key] ?? $default;
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param mixed $keys    A list of keys that can obtained in a single operation.
     * @param mixed $default Default value to return for keys that do not exist.
     *
     * @return mixed A list of key => value pairs. Cache keys that do not exist or
     *                        are stale will have $default as value.
     */
    public function getMultiple(iterable $keys, mixed $default = null): iterable
    {
        // TODO: Implement getMultiple() method.
        return [];
    }

    /**
     * Get the cache store implementation.
     *
     * @return \Illuminate\Contracts\Cache\Store|mixed
     */
    public function getStore()
    {
        // TODO: Implement getStore() method.
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param string|mixed $key They key to check
     *
     * @return bool|mixed
     */
    public function has(string $key): bool
    {
        return isset($this->cache[$key]);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string|mixed $key   The key
     * @param  mixed        $value The value
     *
     * @return int|bool|mixed
     */
    public function increment($key, $value = 1)
    {
        // TODO: Implement increment() method.
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param string|mixed $key     The key to pull out
     * @param mixed        $default The default value
     *
     * @return mixed
     */
    public function pull($key, $default = null)
    {
        // TODO: Implement pull() method.
    }

    /**
     * Store an item in the cache.
     *
     * @param  string|mixed                               $key     The key
     * @param  mixed                                      $value   The value
     * @param  \DateTimeInterface|\DateInterval|float|int $minutes The time
     *
     * @return void|mixed
     */
    public function put($key, $value, $minutes = null)
    {
        $this->cache[$key] = $value;
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param  string|mixed                               $key      The key
     * @param  \DateTimeInterface|\DateInterval|float|int $minutes  The minutes
     * @param  \Closure                                   $callback The callback
     *
     * @return mixed
     */
    public function remember($key, $minutes, Closure $callback)
    {
        return $callback();
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param string|mixed $key      The key
     * @param \Closure     $callback The closure
     *
     * @return mixed
     */
    public function rememberForever($key, Closure $callback)
    {
        return $callback();
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param string|mixed $key      The key
     * @param Closure      $callback The callback
     *
     * @return mixed
     */
    public function sear($key, Closure $callback)
    {
        // TODO: Implement sear() method.
    }

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string|mixed           $key   The key of the item to store.
     * @param mixed                  $value The value of the item to store, must be serializable.
     * @param null|int|\DateInterval $ttl   Optional. The TTL value of this item. If no value is sent and
     *                                      the driver supports TTL then the library may set a default value
     *                                      for it or let the driver take care of that.
     */
    public function set(string $key, mixed $value, null|int|\DateInterval $ttl = null): bool
    {
        $this->cache[$key] = $value;
        return true;
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     */
    public function setMultiple(iterable $values, null|int|\DateInterval $ttl = null): bool
    {
        // TODO: Implement setMultiple() method.
        return true;
    }
}
