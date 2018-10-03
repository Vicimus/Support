<?php declare(strict_types = 1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Locale\NgLocaleSniffer;

/**
 * Class LocaleSniff
 */
class LocaleSniff extends Command
{
    /**
     * The signature for the command
     *
     * @var string
     */
    protected $signature = 'locale:sniff {path} {messages}';

    /**
     * Handle the command being fired
     *
     * @param NgLocaleSniffer $sniffer The sniffer
     *
     * @return void
     */
    public function handle(NgLocaleSniffer $sniffer): void
    {
        $sniffer->use($this->argument('messages'));
        $path = $this->argument('path');

        $keys = $sniffer->parseKeysFromContent($path);
        $context = $sniffer->find($keys);
    }
}
