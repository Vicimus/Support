<?php

declare(strict_types=1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\Locale\LangGenerator;

class GenerateLangFiles extends Command
{
    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $signature = 'locale:generate {locales=en}';

    public function handle(LangGenerator $generator): void
    {
        $locales = explode(',', $this->argument('locales'));
        $generator->bind(new StandardOutput())->fire(app_path(), resource_path('lang'), $locales);

        $generator = new LangGenerator();
        $generator->bind(new StandardOutput())->fire(resource_path('views'), resource_path('lang'), $locales);
    }
}
