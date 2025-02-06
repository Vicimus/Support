<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

use Illuminate\Contracts\Cache\Repository;
use Shared\Exceptions\LocaleException;

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
            $data = $this->getLocale($locale);

            if (config('vicimus.translation-mark')) {
                $revised = [];
                foreach ($data as $key => $value) {
                    if (is_array($value)) {
                        $inner = [];
                        foreach ($value as $k => $v) {
                            $inner[$k] = sprintf('[[%s]]', $v);
                        }

                        $revised[$key] = $inner;
                        continue;
                    }

                    $revised[$key] = sprintf('[[%s]]', $value);
                }
                $data = $revised;
            }

            return $data;
        }

        $key = sprintf('i18n-%s', $locale);
        return $this->cache->remember($key, now()->addDay(), function () use ($locale) {
            return $this->getLocale($locale);
        });
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

        return include $path;
    }
}
