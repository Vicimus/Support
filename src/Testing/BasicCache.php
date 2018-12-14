<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Closure;
use Illuminate\Contracts\Cache\Repository;

/**
 * Class BasicCache
 */
class BasicCache implements Repository
{
    /**
     * Cache store
     * @var mixed[]
     */
    protected $cache = [];

    /**
     * Persists data in the cache, uniquely referenced by a key with an optional expiration TTL time.
     *
     * @param string|mixed           $key   The key of the item to store.
     * @param mixed                  $value The value of the item to store, must be serializable.
     * @param null|int|\DateInterval $ttl   Optional. The TTL value of this item. If no value is sent and
     *                                      the driver supports TTL then the library may set a default value
     *                                      for it or let the driver take care of that.
     *
     * @return bool|mixed True on success and false on failure.
     */
    public function set($key, $value, $ttl = null)
    {
        $this->cache[$key] = $value;
        return true;
    }

    /**
     * Delete an item from the cache by its unique key.
     *
     * @param string|mixed $key The unique cache key of the item to delete.
     *
     * @return bool|mixed True if the item was successfully removed. False if there was an error.
     */
    public function delete($key)
    {
        unset($this->cache[$key]);
    }

    /**
     * Wipes clean the entire cache's keys.
     *
     * @return bool|mixed True on success and false on failure.
     */
    public function clear()
    {
        $this->cache = [];
    }

    /**
     * Obtains multiple cache items by their unique keys.
     *
     * @param iterable $keys    A list of keys that can obtained in a single operation.
     * @param mixed    $default Default value to return for keys that do not exist.
     *
     * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if $keys is neither an array nor a Traversable,
     *   or if any of the $keys are not a legal value.
     */
    public function getMultiple($keys, $default = null)
    {
        // TODO: Implement getMultiple() method.
    }

    /**
     * Persists a set of key => value pairs in the cache, with an optional TTL.
     *
     * @param iterable               $values A list of key => value pairs for a multiple-set operation.
     * @param null|int|\DateInterval $ttl    Optional. The TTL value of this item. If no value is sent and
     *                                       the driver supports TTL then the library may set a default value
     *                                       for it or let the driver take care of that.
     *
     * @return bool True on success and false on failure.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if $values is neither an array nor a Traversable,
     *   or if any of the $values are not a legal value.
     */
    public function setMultiple($values, $ttl = null)
    {
        // TODO: Implement setMultiple() method.
    }

    /**
     * Deletes multiple cache items in a single operation.
     *
     * @param iterable $keys A list of string-based keys to be deleted.
     *
     * @return bool True if the items were successfully removed. False if there was an error.
     *
     * @throws \Psr\SimpleCache\InvalidArgumentException
     *   MUST be thrown if $keys is neither an array nor a Traversable,
     *   or if any of the $keys are not a legal value.
     */
    public function deleteMultiple($keys)
    {
        // TODO: Implement deleteMultiple() method.
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string|mixed $key     The key to get
     * @param  mixed        $default The default to return
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->cache[$key] ?? $default;
    }

    /**
     * Determine if an item exists in the cache.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function has($key)
    {
        // TODO: Implement has() method.
    }

    /**
     * Retrieve an item from the cache and delete it.
     *
     * @param  string $key
     * @param  mixed  $default
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
     * @param  string                                     $key
     * @param  mixed                                      $value
     * @param  \DateTimeInterface|\DateInterval|float|int $minutes
     *
     * @return void
     */
    public function put($key, $value, $minutes)
    {
        // TODO: Implement put() method.
    }

    /**
     * Store an item in the cache if the key does not exist.
     *
     * @param  string                                     $key
     * @param  mixed                                      $value
     * @param  \DateTimeInterface|\DateInterval|float|int $minutes
     *
     * @return bool
     */
    public function add($key, $value, $minutes)
    {
        // TODO: Implement add() method.
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        // TODO: Implement increment() method.
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        // TODO: Implement decrement() method.
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string $key
     * @param  mixed  $value
     *
     * @return void
     */
    public function forever($key, $value)
    {
        // TODO: Implement forever() method.
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result.
     *
     * @param  string                                     $key
     * @param  \DateTimeInterface|\DateInterval|float|int $minutes
     * @param  \Closure                                   $callback
     *
     * @return mixed
     */
    public function remember($key, $minutes, Closure $callback)
    {
        // TODO: Implement remember() method.
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param  string   $key
     * @param  \Closure $callback
     *
     * @return mixed
     */
    public function sear($key, Closure $callback)
    {
        // TODO: Implement sear() method.
    }

    /**
     * Get an item from the cache, or execute the given Closure and store the result forever.
     *
     * @param  string   $key
     * @param  \Closure $callback
     *
     * @return mixed
     */
    public function rememberForever($key, Closure $callback)
    {
        // TODO: Implement rememberForever() method.
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string $key
     *
     * @return bool
     */
    public function forget($key)
    {
        // TODO: Implement forget() method.
    }

    /**
     * Get the cache store implementation.
     *
     * @return \Illuminate\Contracts\Cache\Store
     */public function getStore() {
 // TODO: Implement getStore() method.
    }
}
