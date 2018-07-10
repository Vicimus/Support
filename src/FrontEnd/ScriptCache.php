<?php declare(strict_types = 1);

namespace Vicimus\Support\FrontEnd;

use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

use function array_search;

/**
 * Class ScriptCache
 */
class ScriptCache
{
    /**
     * The app name
     * @var null|string
     */
    private $appName;

    /**
     * The cache repository
     *
     * @var Repository
     */
    private $cache;

    /**
     * Path to the front end files
     *
     * @var string
     */
    private $pathToFrontEnd;

    /**
     * ScriptCache constructor.
     *
     * @param Repository  $cache          The cache repository
     * @param string      $pathToFrontEnd The path to where front end locales are (Must be public)
     * @param null|string $appName        Optionally provide a name for the app
     */
    public function __construct(Repository $cache, string $pathToFrontEnd, ?string $appName = null)
    {
        $this->appName = $appName ?? md5($pathToFrontEnd);
        $this->cache = $cache;
        $this->pathToFrontEnd = $pathToFrontEnd;
        $this->relativeFrontEnd = '';
    }

    /**
     * Check if cache exists
     *
     * @param string $locale The locale to check
     *
     * @return bool
     */
    public function areUnhealthy(string $locale = 'en'): bool
    {
        return !$this->cache->has('rms-ui-cache-' . $locale);
    }

    /**
     * Read the script directory and cache the file names
     *
     * @return void
     */
    public function cache(): void
    {
        $order = [
            'runtime',
            'polyfill',
            'main',
        ];

        $finder = new Finder();
        foreach ($finder->directories()->in($this->pathToFrontEnd)->depth(0) as $locale) {
            $names = [];
            $paths = [];

            $fileFinder = new Finder();
            /** @var SplFileInfo $locale */
            $localeName = $locale->getRelativePathname();
            $fileFinder->files()->in($locale->getRealPath())->name('*.js')->depth(0);
            foreach ($fileFinder as $file) {
                $name = $this->extract($file->getRelativePathname());
                $name = 'js_' . $localeName . '_' . $name;
                $names[] = $name;

                $paths[$name] = url('rms-ui/' . $localeName .'/' . $file->getRelativePathname());
            }

            $fileFinder = new Finder();
            $fileFinder->files()->in($locale->getRealPath())->name('*.css')->depth(0);
            foreach ($fileFinder as $file) {
                $name = $this->extract($file->getRelativePathname());
                $name = 'css_' . $localeName . '_' . $name;
                $names[] = $name;
                $paths[$name] = url('rms-ui/' . $localeName . '/' . $file->getRelativePathname());
            }

            $cached = [];
            foreach ($names as $name) {
                $cached[] = $paths[$name];
            }

            // Split up the scripts and styles
            $scripts = array_filter($cached, function ($name): bool {
                return substr($name, -2) === 'js';
            });

            $styles = array_filter($cached, function ($name): bool {
                return substr($name, -3) === 'css';
            });

            usort($scripts, function ($aPath, $bPath) use ($order) {
                $aName = $this->getName($aPath);
                $bName = $this->getName($bPath);

                $aPosition = array_search($aName, $order, true);
                $bPosition = array_search($bName, $order, true);

                if ($aPosition === $bPosition) {
                    return 0;
                }

                return ($aPosition > $bPosition) ? 1 : -1;
            });


            $this->cache->forever(sprintf('%s-cache-%s', $this->appName, $localeName), [$scripts, $styles]);
        }
    }

    /**
     * Clear the cache
     *
     * @return void
     */
    public function forget(): void
    {
        $finder = new Finder();
        foreach ($finder->directories()->in($this->pathToFrontEnd)->depth(0) as $locale) {
            /** @var SplFileInfo $locale */
            $localeName = $locale->getRelativePathname();

            $this->cache->forget(sprintf('%s-cache-%s', $this->appName, $localeName));
        }
    }

    /**
     * Extract the simple name of the script. This will be used as the cache
     * key
     *
     * @param string $filename The full filename
     *
     * @return string
     */
    protected function extract(string $filename): string
    {
        return substr($filename, 0, strpos($filename, '.'));
    }

    /**
     * Get the name from a path
     *
     * @param string $filename The filename to look at
     *
     * @return string
     */
    private function getName(string $filename): string
    {
        if (stripos($filename, 'main.')) {
            return 'main';
        }

        if (stripos($filename, 'runtime.')) {
            return 'runtime';
        }

        return 'polyfill';
    }
}
