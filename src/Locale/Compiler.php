<?php

declare(strict_types=1);

namespace Vicimus\Support\Locale;

use Exception;
use Illuminate\Contracts\Cache\Repository;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\LocaleException;

class Compiler
{
    private Repository $cache;

    private string $env;

    private string $file;

    private string $pathToLang;

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
     * @return string[]
     *
     * @throws LocaleException
     */
    public function get(string $locale): array
    {
        if ($this->env !== 'production') {
            return $this->getLocale($locale);
        }

        $key = sprintf('i18n-%s', $locale);
        return $this->cache->remember($key, 30, fn () => $this->getLocale($locale));
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

        return include $path;
    }
}
