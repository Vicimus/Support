<?php

declare(strict_types=1);

namespace Vicimus\Support\Facades;

use DateTimeInterface;
use Illuminate\Support\Facades\Cache as LaravelCache;

/**
 * Class Cache
 *
 * @method static mixed remember(string $key, int|DateTimeInterface $ttl, callable $closure)
 */
class Cache extends LaravelCache
{
    //
}
