<?php

declare(strict_types=1);

namespace Vicimus\Support\Locale;

use Exception;
use RuntimeException;
use Symfony\Component\Finder\Finder;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\LocaleException;

class Compiler
{
    public function __construct(
        private string $pathToLang,
        private string $file = 'i18n.php'
    ) {
    }

    /**
     * Get translations for a specific locale
     *
     * @return string[]
     *
     * @throws LocaleException
     */
    public function get(string $locale): array
    {
        return $this->getLocale($locale);
    }

    /**
     * @param string[]|string[][] $translations The translations
     * @param string              $prefix       The prefix
     *
     * @return Translation[]|Translation[][]
     *
     * @throws RuntimeException
     */
    private function castToTranslations(array $translations, string $prefix = ''): array
    {
        $converted = [];
        foreach ($translations as $key => $value) {
            if (is_string($value)) {
                $converted[$key] = new Translation($key, $value, $prefix ? sprintf('%s.%s', $prefix, $key) : $key);
                continue;
            }

            if (!is_array($value)) {
                throw new RuntimeException('Expected string or array but got something else');
            }

            if (!$this->isComplexTranslation($value)) {
                $converted[$key] = $this->castToTranslations($value, $key);
                continue;
            }

            $converted[$key] = new Translation($key, $value, $prefix ? sprintf('%s.%s', $prefix, $key) : $key);
        }

        return $converted;
    }

    /**
     * Get a specific locale content
     *
     * @return string[]
     * @throws LocaleException
     *
     * I have to disable phpcs here because it cannot figure out the anonymous exception
     * phpcs:disable
     */
    private function getLocale(string $locale): array
    {
        $path = sprintf('%s/%s/%s', $this->pathToLang, $locale, $this->file);
        if (!file_exists($path)) {
            $ex = new class extends Exception implements LocaleException {
                //
            };

            throw new $ex(sprintf('Locale [%s] is not supported at this time', $locale));
        }

        return $this->read($path);
    }

    /**
     * @param string[] $value The value to check
     *
     * @return bool
     */
    private function isComplexTranslation(array $value): bool
    {
        return array_keys($value) === range(0, count($value) - 1);
    }

    /**
     * Dynamically read all the i18n files
     *
     * @param string $path            The path to the base i18n file
     * @param bool   $dynamicallyLoad Should we dynamically load other files
     *
     * @return string[]|string[][]
     *
     * @throws RuntimeException
     */
    private function read(string $path, bool $dynamicallyLoad = true): array
    {
        $uncategorized = require $path;
        if (!$dynamicallyLoad) {
            return $this->transform($this->castToTranslations($uncategorized));
        }

        $main = $uncategorized;

        $filename = pathinfo($path)['filename'];
        $searchPath = sprintf('%s/%s', pathinfo($path)['dirname'], $filename);

        if (file_exists($searchPath) && is_dir($searchPath)) {
            $finder = new Finder();
            foreach ($finder->files()->ignoreDotFiles(true)->in($searchPath) as $file) {
                $key = pathinfo($file->getFileInfo()->getFilename())['filename'];
                if (array_key_exists($key, $main)) {
                    throw new RuntimeException(sprintf(
                        'Key for file [%s] already exists when building i18n master array',
                        $file->getFileInfo()->getFilename(),
                    ));
                }

                $category = require $file->getPathname();
                $main[$key] = $category;
            }
        }

        return $this->transform($this->castToTranslations($main));
    }

    /**
     * Convert the Translation instances to their values
     *
     * @param Translation[]|Translation[][] $translations The translations
     *
     * @return string[]|string[][]
     *
     * @throws RuntimeException
     */
    private function transform(array $translations): array
    {
        $result = [];

        foreach ($translations as $key => $value) {
            if (is_array($value)) {
                $result[$key] = $this->transform($value);
                continue;
            }

            if (!$value instanceof Translation) {
                throw new RuntimeException(sprintf('Translation [%s] must be an instance of Translation', $key));
            }

            $result[$key] = $value->value;
        }

        return $result;
    }
}
