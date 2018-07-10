<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

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
     * Generate lang files
     *
     * @param string   $path       The path to scan
     * @param string   $localePath The path to write locale files
     * @param string[] $locales    The locales to generate
     *
     * @return void
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
     * Process a path
     *
     * @param string   $path       The path to process
     * @param string[] $dictionary The dictionary of keys and values
     *
     * @throws DuplicateTranslationException
     * @return void
     */
    private function process(string $path, array &$dictionary): void
    {
        $contents = file_get_contents($path);
        $matches = [];
        preg_match_all('/___\(.*?\)/s', $contents, $matches);
        var_dump($matches);
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
     * Write a locale file
     *
     * @param string   $localePath The locale path
     * @param string[] $locales    The locales
     * @param string[] $dictionary The dictionary
     *
     * @return void
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
}
