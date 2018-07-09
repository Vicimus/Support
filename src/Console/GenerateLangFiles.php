<?php declare(strict_types = 1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\Locale\LangGenerator;

/**
 * Class GenerateLangFiles
 */
class GenerateLangFiles extends Command
{
    /**
     * The signature
     * @var string
     */
    protected $signature = 'locale:generate {locales=en}';

    /**
     * Generate lang files
     *
     * @param LangGenerator $generator The generator
     *
     * @return void
     * @throws \Vicimus\Support\Exceptions\DuplicateTranslationException
     */
    public function handle(LangGenerator $generator): void
    {
        $locales = explode(',', $this->argument('locales'));
        $generator->bind(new StandardOutput())->fire(app_path(), resource_path('lang'), $locales);
    }
}
