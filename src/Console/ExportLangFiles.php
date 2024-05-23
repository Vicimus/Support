<?php

declare(strict_types=1);

namespace Vicimus\Support\Console;

use Illuminate\Console\Command;
use Vicimus\Support\Classes\StandardOutput;
use Vicimus\Support\Locale\LangGenerator;

/**
 * Class ExportLangFiles
 */
class ExportLangFiles extends Command
{
    /**
     * The commands signature
     */
    protected string $signature = 'locale:export {locale} {target?}';

    /**
     * Export the files
     *
     * @param LangGenerator $generator The lang generator service
     *
     */
    public function handle(LangGenerator $generator): void
    {
        $target = $this->argument('target');
        if (!$target) {
            $target = storage_path('export-' . $this->argument('locale') . '.php');
        }

        $generator->bind(new StandardOutput())->export(
            $this->argument('locale'),
            resource_path('lang'),
            $target
        );
    }
}
