<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

use Illuminate\Contracts\Cache\Repository;
use Shared\Exceptions\LocaleException;
use Symfony\Component\Finder\Finder;

/**
 * Class Compiler
 */
class Compiler
{
    /**
     * Cache repository
     *
     * @var Repository
     */
    private $cache;

    /**
     * The environment
     *
     * @var string
     */
    private $env;

    /**
     * The file to read
     *
     * @var string
     */
    private $file;

    /**
     * The path to the lang files
     *
     * @var string
     */
    private $pathToLang;

    /**
     * Compiler constructor.
     *
     * @param Repository $cache      The cache repository
     * @param string     $env        The current environment
     * @param string     $pathToLang The path to the lang files
     * @param string     $file       The file to read
     */
    public function __construct(Repository $cache, string $env, string $pathToLang, string $file = 'i18n.php')
    {
        $this->cache = $cache;
        $this->file = $file;
        $this->env = $env;
        $this->pathToLang = $pathToLang;
    }

    /**
     * Get translations for a specific locale
     *
     * @param string $locale The locale you want to get
     *
     * @return string[]
     *
     * @throws LocaleException
     */
    public function get(string $locale): array
    {
        if ($this->env !== 'production') {
            return $this->getLocale($locale);
        }

        return $this->cache->rememberForever(sprintf('i18n-%s', $locale), fn () => $this->getLocale($locale));
    }

    /**
     * Get a specific locale content
     *
     * @param string $locale The locale to get
     *
     * @return string[]
     *
     * @throws LocaleException
     */
    private function getLocale(string $locale): array
    {
        $path = sprintf('%s/%s/%s', $this->pathToLang, $locale, $this->file);
        if (!file_exists($path)) {
            throw new LocaleException(sprintf('Locale [%s] is not supported at this time', $locale));
        }

        /** @var string[]|string[][] $uncategorized */
        $uncategorized = require $path;
        $main = $this->parseTranslationArray($uncategorized);

        $filename = pathinfo($this->file)['filename'];
        $searchPath = sprintf('%s/%s/%s', $this->pathToLang, $locale, $filename);

        $finder = new Finder();
        foreach ($finder->files()->ignoreDotFiles(true)->in($searchPath) as $file) {
            $key = pathinfo($file->getFileInfo()->getFilename())['filename'];
            if (array_key_exists($key, $main)) {
                throw new LocaleException(sprintf(
                    'Key for file [%s] already exists',
                    $file->getFileInfo()->getFilename(),
                ));
            }

            $category = require $file->getPathname();
            $main[$key] = $this->parseTranslationArray($category);
        }

        return $main;
    }

    private function parseTranslationArray(array $translations): array
    {
        $revised = [];
        foreach ($translations as $key => $value) {
            if (!is_array($value)) {
                $revised[$key] = $value;
                continue;
            }

            if (!is_array($value[0])) {
                $revised[$key] = $value[0];
                continue;
            }

            $revised[$key] = $key;
        }

        return $revised;
    }
}
