<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

use Illuminate\Contracts\Cache\Repository;

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
     */
    public function get(string $locale): array
    {
        if ($this->env !== 'production') {
            return $this->getLocale($locale);
        }

        $key = sprintf('i18n-%s', $locale);
        return $this->cache->remember($key, 30, function () use ($locale) {
            return $this->getLocale($locale);
        });
    }

    /**
     * Get a specific locale content
     *
     * @param string $locale The locale to get
     *
     * @return string[]
     */
    private function getLocale(string $locale): array
    {
        $path = sprintf('%s/%s/%s', $this->pathToLang, $locale, $this->file);
        return include $path;
    }
}
