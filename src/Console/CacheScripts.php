<?php

declare(strict_types=1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\FrontEnd\ScriptCache;

/**
 * Class CacheScripts
 */
class CacheScripts extends Command
{
    /**
     * The script cache
     *
     */
    protected ScriptCache $cache;

    /**
     * The description
     *
     */
    protected string $description = 'Read and cache script names';

    /**
     * Command signature
     *
     */
    protected string $signature = 'scripts:cache';

    /**
     * CacheScripts constructor
     *
     * @param ScriptCache $cache The script cache object
     */
    public function __construct(ScriptCache $cache)
    {
        parent::__construct();
        $this->cache = $cache;
    }

    /**
     * Fire the command
     *
     */
    public function handle(): void
    {
        $this->cache->bind(new StandardOutput());
        $this->cache->forget();
        $this->cache->cache();
    }
}
