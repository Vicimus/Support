<?php

declare(strict_types=1);

namespace Vicimus\Support\FrontEnd;

use Illuminate\Contracts\Cache\Repository;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

use function array_search;

class ScriptCache implements ConsoleOutput
{
    use ConsoleOutputter;

    private ?string $appName;

    private string $relativeFrontEnd;

    public function __construct(
        private Repository $cache,
        private string $pathToFrontEnd,
        ?string $appName = null
    ) {
        $this->appName = $appName ?? md5($pathToFrontEnd);
        $this->relativeFrontEnd = str_replace(public_path() . '/', '', $pathToFrontEnd);
    }

    public function areUnhealthy(string $locale = 'en'): bool
    {
        return !$this->cache->has(sprintf('%s-cache-%s', $this->appName, $locale));
    }

    public function baseHref(string $locale = 'en'): string
    {
        return $this->pathToFrontEnd . '/' . $locale;
    }

    public function cache(): void
    {
        $order = [
            'runtime',
            'polyfills',
            'scripts',
            'main',
        ];

        $finder = new Finder();
        /** @var SplFileInfo $locale */
        foreach ($finder->directories()->in($this->pathToFrontEnd)->depth(0) as $locale) {
            $names = [];
            $paths = [];

            $fileFinder = new Finder();

            $localeName = $locale->getRelativePathname();
            $fileFinder->files()->in($locale->getRealPath())->name('*.js')->depth(0);
            foreach ($fileFinder as $file) {
                $name = $this->extract($file->getRelativePathname());
                dd($name);
                if (is_numeric($name[0])) {
                    continue;
                }

                $name = 'js_' . $localeName . '_' . $name;
                $names[] = $name;

                $paths[$name] = url(sprintf(
                    '%s/%s/%s',
                    $this->relativeFrontEnd,
                    $localeName,
                    $file->getRelativePathname()
                ));
            }

            $fileFinder = new Finder();
            $fileFinder->files()->in($locale->getRealPath())->name('*.css')->depth(0);
            foreach ($fileFinder as $file) {
                $name = $this->extract($file->getRelativePathname());
                $name = 'css_' . $localeName . '_' . $name;
                $names[] = $name;
                $paths[$name] = url(sprintf(
                    '%s/%s/%s',
                    $this->relativeFrontEnd,
                    $localeName,
                    $file->getRelativePathname()
                ));
            }

            $cached = [];
            foreach ($names as $name) {
                $cached[] = $paths[$name];
            }

            // Split up the scripts and styles
            $scripts = array_filter($cached, static fn ($name): bool => substr($name, -2) === 'js');

            $styles = array_filter($cached, static fn ($name): bool => substr($name, -3) === 'css');

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

            $this->comment('Cached %s-cache-%s', $this->appName, $localeName);
            $this->cache->forever(sprintf('%s-cache-%s', $this->appName, $localeName), [$scripts, $styles]);
        }
    }

    public function forget(): void
    {
        $finder = new Finder();
        foreach ($finder->directories()->in($this->pathToFrontEnd)->depth(0) as $locale) {
            /** @var SplFileInfo $locale */
            $localeName = $locale->getRelativePathname();

            $this->line('Forgetting %s-cache-%s', $this->appName, $localeName);
            $this->cache->forget(sprintf('%s-cache-%s', $this->appName, $localeName));
        }
    }

    protected function extract(string $filename): string
    {
        return substr($filename, 0, strpos($filename, '.'));
    }

    private function getName(string $filename): string
    {
        if (stripos($filename, 'main')) {
            return 'main';
        }

        if (stripos($filename, 'runtime')) {
            return 'runtime';
        }

        if (stripos($filename, 'scripts')) {
            return 'scripts';
        }

        return 'polyfills';
    }
}
