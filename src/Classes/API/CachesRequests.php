<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\API;

use Illuminate\Contracts\Cache\Repository;

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
}
