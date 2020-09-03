<?php

declare(strict_types=1);

namespace Vicimus\Support\Facades;

use DateTimeInterface;
use Illuminate\Support\Facades\Cache as LaravelCache;

/**
 * Class Cache
 *
 * @method static mixed remember(string $key, int|DateTimeInterface $ttl, callable $closure)
 * @method static mixed forget(string $key)
 * @method static bool has(string $key)
 * @method static void put(string $key, $value, int|DateTimeInterface $ttl)
 * @method static mixed get(string $key)
 */
class Cache extends LaravelCache
{
    //
}
