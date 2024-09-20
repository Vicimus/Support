<?php

declare(strict_types=1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Locale\NgLocaleSniffer;

class LocaleSniff extends Command
{
    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $description = 'Sniffs the angular i18n messages file for missing ' .
    'translation keys';

    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $signature = 'locale:sniff {path?} {--count}';

    public function handle(NgLocaleSniffer $sniffer): void
    {
        $path = $sniffer->path();
        if (!$sniffer->path()) {
            $path = $this->argument('path');
        }

        $missing = $sniffer->missing($path);
        if ($this->option('count')) {
            $this->info(count($missing) . ' missing translations');
            return;
        }

        $array = [];
        foreach ($missing as $row) {
            $array[$row->id] = $row->original;
        }

        $this->info('<?php declare(strict_types = 1)' . PHP_EOL);
        $this->info(var_export($array, true));
    }
}
