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
     * Description
     * @var string
     */
    protected $description = 'Sniffs the angular i18n messages file for missing ' .
        'translation keys';

    /**
     * The signature for the command
     *
     * @var string
     */
    protected $signature = 'locale:sniff {path?} {--count}';

    /**
     * Handle the command being fired
     *
     * @param NgLocaleSniffer $sniffer The sniffer
     *
     * @return void
     */
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
