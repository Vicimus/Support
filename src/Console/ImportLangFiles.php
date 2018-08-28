<?php declare(strict_types = 1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\Locale\LangGenerator;

/**
 * Class ExportLangFiles
 */
class ImportLangFiles extends Command
{
    /**
     * The commands signature
     * @var string
     */
    protected $signature = 'locale:import {path} {locale}';

    /**
     * Export the files
     *
     * @param LangGenerator $generator The lang generator service
     *
     * @return void
     */
    public function handle(LangGenerator $generator): void
    {
        $generator->bind(new StandardOutput())->import(
            $this->argument('path'),
            $this->argument('locale'),
            resource_path('lang')
        );
    }
}
