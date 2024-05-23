<?php

declare(strict_types=1);

namespace Vicimus\Support\Locale;

use DateTime;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Vicimus\Support\Exceptions\DuplicateTranslationException;
use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class LangGenerator
 */
class LangGenerator implements ConsoleOutput
{
    use ConsoleOutputter;

    /**
     * Export the crap out of the lang files
     *
     * @param string $locale         The locale to export
     * @param string $localePath     Locale path
     * @param string $target         The target to save the export
     * @param string $compareAgainst Compare against
     *
     */
    public function export(
        string $locale,
        string $localePath,
        string $target,
        string $compareAgainst = 'en'
    ): void {
        $path = sprintf('%s/%s', $localePath, $locale);

        $finder = new Finder();
        $finder->files()->in($path)->name('*.php');
        $batch = [];
        foreach ($finder as $file) {
            $key = str_replace('.php', '', $file->getFilename());
            $batch[$key] = include $file;
        }

        $compare = [];
        $finder = new Finder();
        $comparePath = sprintf('%s/%s', $localePath, $compareAgainst);
        $finder->files()->in($comparePath)->name('*.php');
        foreach ($finder as $file) {
            $key = str_replace('.php', '', $file->getFilename());
            $compare[$key] = include $file;
        }

        $final = [];
        foreach ($batch as $key => $section) {
            $section = array_merge($compare[$key], $section);
            ksort($section);
            $diff = array_intersect($compare[$key], $section);

            if (!count($diff)) {
                continue;
            }

            $final[$key] = $diff;
        }

        $this->writeExport($final, $target, $locale, $compareAgainst);
    }

    /**
     * Generate lang files
     *
     * @param string   $path       The path to scan
     * @param string   $localePath The path to write locale files
     * @param string[] $locales    The locales to generate
     *
     * @throws DuplicateTranslationException
     */
    public function fire(string $path, string $localePath, array $locales): void
    {
        $dictionary = [];

        $finder = new Finder();
        $finder->files()->in($path)->name('*.php')->contains('___(');
        foreach ($finder as $file) {
            $this->line('%s', $file->getRelativePathname());
            $this->process($file->getRealPath(), $dictionary);
        }

        $this->info('Found %s keys', count($dictionary));

        $this->writeFiles($localePath, $locales, $dictionary);
    }

    /**
     * Import a translated master file and break it into it's parts
     *
     * @param string $path       The path of the master file to read
     * @param string $locale     The locale this is
     * @param string $localePath The path to the locale files
     *
     */
    public function import(string $path, string $locale, string $localePath): void
    {
        $master = include $path;
        foreach ($master as $pack => $section) {
            $originalPath = sprintf('%s/%s/%s.php', $localePath, $locale, $pack);
            $original = include $originalPath;
            $merged = array_merge($original, $section);

            $this->writeMerged($merged, $originalPath, $locale);
        }
    }

    /**
     * Process a path
     *
     * @param string   $path       The path to process
     * @param string[] $dictionary The dictionary of keys and values
     *
     * @throws DuplicateTranslationException
     */
    private function process(string $path, array &$dictionary): void
    {
        $contents = file_get_contents($path);
        $matches = [];
        preg_match_all('/___\(.*?\)/s', $contents, $matches);

        foreach ($matches ?? [] as $matchRow) {
            foreach ($matchRow as $match) {
                if (strpos($match, '\'') === false) {
                    $this->comment('Unprocessed key due to being programmatic: ' . $match);
                    continue;
                }

                $line = str_replace(['___(\'', '\'))', '\')',], '', $match);
                [$key, $value] = explode(',', $line, 2);
                $key = substr(trim($key), 0, -1);
                $value = substr(trim($value), 1);
                if (isset($dictionary[$key]) && $dictionary[$key] !== $value) {
                    throw new DuplicateTranslationException(sprintf(
                        'The key [%s] was found more than once and it has different values. ' .
                        'The first key is [%s], the second key was [%s]',
                        $key,
                        $dictionary[$key],
                        $value
                    ));
                }

                $dictionary[$key] = $value;
            }
        }
    }

    /**
     * Write the export file
     *
     * @param mixed[] $final    The final array to write
     * @param string  $target   The target path
     * @param string  $locale   The locale
     * @param string  $compared The compared locale
     *
     */
    private function writeExport(array $final, string $target, string $locale, string $compared): void
    {
        $export = ' ' . var_export($final, true);
        $export = str_replace([' array (', '),', "=> \n"], ['[', "],\n", '=>'], $export);
        $export = substr($export, 0, -1) . '];';
        $export = 'return ' . $export;

        $contents = file_get_contents(__DIR__ . '/../../resources/views/locale-export.php');
        $contents = str_replace([
            '{{LOCALE}}', '{{COMPARED}}', '{{DATE}}', '/*{{EXPORT}}*/',
        ], [
            $locale, $compared, '[' . (new DateTime())->format('F d, Y \a\t h:i A') . ']', $export,
        ], $contents);

        file_put_contents($target, $contents);
    }

    /**
     * Write a locale file
     *
     * @param string   $localePath The locale path
     * @param string[] $locales    The locales
     * @param string[] $dictionary The dictionary
     *
     *
     * @throws RuntimeException
     */
    private function writeFiles(string $localePath, array $locales, array $dictionary): void
    {
        $files = [];

        foreach ($dictionary as $key => $value) {
            $parts = explode('.', $key);
            $arrayKey = array_splice($parts, -1, 1)[0];
            $filePath = implode('/', $parts);

            if (!isset($files[$filePath])) {
                $files[$filePath] = [];
            }

            $files[$filePath][$arrayKey] = $value;
        }

        foreach ($locales as $locale) {
            foreach ($files as $file => $values) {
                $path = sprintf('%s/%s', $localePath, $locale);
                if (!file_exists($path) && !mkdir($path) && !is_dir($path)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $path));
                }

                $target = sprintf('%s/%s/%s.php', $localePath, $locale, $file);

                if (file_exists($target)) {
                    $existing = include $target;

                    $values = array_merge($values, $existing);
                }

                ksort($values);

                $output = '<?php declare(strict_types = 1);' . PHP_EOL . PHP_EOL;
                $output .= 'return ';
                $output .= str_replace('array (', '[', substr(var_export($values, true), 0, -1));
                $output .= '];' . PHP_EOL;

                file_put_contents($target, $output);
            }
        }
    }

    /**
     * Write the export file
     *
     * @param mixed[] $final  The final array to write
     * @param string  $target The target path
     *
     */
    private function writeMerged(array $final, string $target): void
    {
        $export = ' ' . var_export($final, true);
        $export = str_replace([' array (', '),', "=> \n"], ['[', "],\n", '=>'], $export);
        $export = substr($export, 0, -1) . '];';
        $export = 'return ' . $export;

        $contents = file_get_contents(__DIR__ . '/../../resources/views/locale-import.php');
        $contents = str_replace([
            '{{DATE}}', '/*{{IMPORT}}*/',
        ], [
            '[' . (new DateTime())->format('F d, Y \a\t h:i A') . ']', $export,
        ], $contents);

        file_put_contents($target, $contents);
    }
}
