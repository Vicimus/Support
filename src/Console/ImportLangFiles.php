<?php

declare(strict_types=1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\Locale\LangGenerator;

class ImportLangFiles extends Command
{
    /**
     * @var string
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    protected $signature = 'locale:import {path} {locale}';

    public function handle(LangGenerator $generator): void
    {
        $generator->bind(new StandardOutput())->import(
            $this->argument('path'),
            $this->argument('locale'),
            resource_path('lang')
        );
    }
}
