<?php

declare(strict_types=1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\FrontEnd\ScriptCache;

class CacheScripts extends Command
{
    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $description = 'Read and cache script names';

    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $signature = 'scripts:cache';

    public function __construct(
        protected readonly ScriptCache $cache,
    ) {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->cache->bind(new StandardOutput());
        $this->cache->forget();
        $this->cache->cache();
    }
}
