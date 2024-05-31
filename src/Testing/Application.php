<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as LaravelApp;
use Illuminate\Http\Request;
use Illuminate\Http\Response as IlluminateResponse;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Throwable;

/**
 * Class Application
 *
 * @SuppressWarnings(PHPMD)
 */
class Application extends Container implements LaravelApp, HttpKernelInterface
{
    /**
     * The request class used by the application.
     *
     */
    protected static string $requestClass = Request::class;

    /**
     * The custom application path defined by the developer.
     *
     */
    protected string $appPath;

    /**
     * The custom database path defined by the developer.
     *
     */
    protected string $databasePath;

    /**
     * The custom environment path defined by the developer.
     *
     */
    protected string $environmentPath;

    /**
     * Providers
     * @var string[]
     */
    protected array $providers = [];

    /**
     * The custom storage path defined by the developer.
     *
     */
    protected string $storagePath;

    /**
     * Testing
     */
    private string $environment = 'testing';

    /**
     * Application constructor.
     *
     * @param string|null $basePath Provide the base path
     */
    public function __construct(?string $basePath = null)
    {
        if (!$basePath) {
            return;
        }

        $this->setBasePath($basePath);
    }

    /**
     * Get the base path of the Laravel installation.
     *
     * @param string $path Optionally, a path to append to the base path
     *
     *
     * @codingStandardsIgnoreStart
     */
    public function basePath($path = ''): string
    {
        // @codingStandardsIgnoreEnd
        return realpath($this->basePath . (($path) ? DIRECTORY_SEPARATOR . $path : $path));
    }

    /**
     * Boot the application's service providers.
     *
     */
    public function boot(): mixed
    {
        //  Implement boot() method.
    }

    /**
     * Register a new "booted" listener.
     *
     * @param mixed $callback The callback
     *
     */
    public function booted(mixed $callback): mixed
    {
        // Implement booted() method.
    }

    /**
     * Register a new boot listener.
     *
     * @param mixed $callback The callback
     *
     * @return void|mixed
     */
    public function booting(mixed $callback): void
    {
        // Implement booting() method.
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @param string|mixed $path Optionally, a path to append to the bootstrap path
     *
     */
    public function bootstrapPath(mixed $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'bootstrap' . (($path) ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Run the given array of bootstrap classes.
     *
     * @param mixed[] $classes Array of bootstrap classes
     *
     */
    public function bootstrapWith(array $classes): void
    {
        // Implement bootstrapWith() method.
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string|mixed $path Optionally, a path to append to the config path
     *
     */
    public function configPath(mixed $path = ''): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'config' . (($path) ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Determine if the application configuration is cached.
     *
     */
    public function configurationIsCached(): bool
    {
        return false;
    }

    /**
     * Get the path to the database directory.
     *
     * @param string|mixed $path Optionally, a path to append to the database path
     */
    public function databasePath(mixed $path = ''): string
    {
        return (($this->databasePath) ?: $this->basePath . DIRECTORY_SEPARATOR . 'database') .
            (($path) ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Detect the application's current environment.
     *
     * @param Closure $callback Closure to detect environment
     *
     */
    public function detectEnvironment(Closure $callback): string
    {
        $this->environment = $callback();
        return $this->environment;
    }

    /**
     * Handle the given request and get the response.
     *
     * @param Request $request The request
     *
     */
    public function dispatch(Request $request): Response
    {
        if ($this->isDownForMaintenance()) {
            $response = $this['events']->until('illuminate.app.down');
            if ($response !== null) {
                return $this->prepareResponse($response);
            }
        }

        if ($this->runningUnitTests() && !$this['session']->isStarted()) {
            $this['session']->start();
        }

        return $this['router']->dispatch($this->prepareRequest($request));
    }

    /**
     * Get or check the current application environment.
     *
     * @param mixed ...$environments The environments
     *
     */
    public function environment(mixed ...$environments): mixed
    {
        if (!count($environments)) {
            return $this->environment;
        }

        return in_array($this->environment, $environments, false);
    }

    /**
     * Get the environment file the application is using.
     *
     */
    public function environmentFile(): string
    {
        return $this->basePath('.env');
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     */
    public function environmentFilePath(): string
    {
        return $this->basePath('.env');
    }

    /**
     * Get the path to the environment file directory.
     *
     */
    public function environmentPath(): string
    {
        return $this->basePath();
    }

    /**
     * Get the path to the configuration cache file.
     *
     */
    public function getCachedConfigPath(): string
    {
        return $this->storagePath() . '/cache';
    }

    /**
     * Get the path to the cached packages.php file.
     *
     */
    public function getCachedPackagesPath(): mixed
    {
        return $this->storagePath() . '/cache';
    }

    /**
     * Get the path to the routes cache file.
     *
     */
    public function getCachedRoutesPath(): string
    {
        return $this->storagePath . '/cache';
    }

    /**
     * Get the path to the cached services.php file.
     *
     */
    public function getCachedServicesPath(): mixed
    {
        return $this->storagePath() . '/cache';
    }

    /**
     * Get the current application locale.
     *
     */
    public function getLocale(): string
    {
        return 'en';
    }

    /**
     * Get the application namespace.
     *
     */
    public function getNamespace(): string
    {
        return '';
    }

    /**
     * Get the registered service provider instances if any exist.
     *
     * @param ServiceProvider|string $provider The providers
     *
     * @return mixed[]
     */
    public function getProviders($provider): array
    {
        if ($provider) {
            $this->providers[] = $provider;
        }

        return $this->providers;
    }

    /**
     * Handle the given request and get the response.
     *
     * Provides compatibility with BrowserKit functional testing.
     *
     * @implements HttpKernelInterface::handle
     *
     * @param SymfonyRequest $request The request instance
     * @param int|mixed      $type    The type of call
     * @param bool|mixed     $catch   Should catch
     *
     *
     * @throws Throwable
     */
    public function handle(
        SymfonyRequest $request,
        mixed $type = HttpKernelInterface::MASTER_REQUEST,
        mixed $catch = true
    ): Response {
        try {
            $request = Request::createFromBase($request);
            $this->refreshRequest($request);

            $this->boot();

            return $this->dispatch($request);
        } catch (Throwable $e) {
            if (!$catch || ($this->runningUnitTests() && $type)) {
                throw $e;
            }

            return $this['exception']->handleException($e);
        }
    }

    /**
     * Determine if the application has been bootstrapped before.
     *
     */
    public function hasBeenBootstrapped(): bool
    {
        return true;
    }

    /**
     * Determine if the application is currently down for maintenance.
     *
     */
    public function isDownForMaintenance(): mixed
    {
        return false;
    }

    /**
     * Get the path to the language files.
     *
     */
    public function langPath(): string
    {
        return $this->resourcePath() . DIRECTORY_SEPARATOR . 'lang';
    }

    /**
     * Load and boot all of the remaining deferred providers.
     *
     */
    public function loadDeferredProviders(): void
    {
        //Implement loadDeferredProviders() method.
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param string|mixed $file Load the file
     *
     */
    public function loadEnvironmentFrom(mixed $file): self
    {
        return $this;
    }

    /**
     * Call a method on the default request class.
     *
     * @param string  $method     The method
     * @param mixed[] $parameters Parameters
     *
     */
    public static function onRequest(string $method, array $parameters = []): mixed
    {
        return forward_static_call_array([static::requestClass(), $method], $parameters);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @param string $path The path to get
     *
     */
    public function path(string $path = ''): string
    {
        $appPath = ($this->appPath) ?: $this->basePath . DIRECTORY_SEPARATOR . 'app';
        return $appPath . (($path) ? DIRECTORY_SEPARATOR . $path : $path);
    }

    /**
     * Prepare the request by injecting any services.
     *
     * @param Request $request The request instance
     *
     */
    public function prepareRequest(Request $request): Request
    {
        if ($this['config']['session.driver'] !== null && !$request->hasSession()) {
            $request->setSession($this['session']->driver());
        }

        return $request;
    }

    /**
     * Prepare the given value as a Response object.
     *
     * @param mixed $value A value
     *
     */
    public function prepareResponse(mixed $value): Response
    {
        if (!$value instanceof SymfonyResponse) {
            $value = new IlluminateResponse($value);
        }

        return $value->prepare($this['request']);
    }

    /**
     * Get the path to the public / web directory.
     *
     */
    public function publicPath(): string
    {
        return $this->basePath . DIRECTORY_SEPARATOR . 'public';
    }

    /**
     * Register a service provider with the application.
     *
     * @param ServiceProvider|string $provider The provider
     * @param bool|mixed             $force    Force
     *
     * @return ServiceProvider|mixed|void
     */
    public function register($provider, $force = false): void
    {
        $this->providers[] = $provider;
        if (!$force) {
            return;
        }
    }

    /**
     * Register all of the configured providers.
     *
     */
    public function registerConfiguredProviders(): mixed
    {
        // Implement registerConfiguredProviders() method when necessary
    }

    /**
     * Register a deferred provider and service.
     *
     * @param string|mixed      $provider The providers
     * @param string|mixed|null $service  The service
     *
     * @return void|mixed
     */
    public function registerDeferredProvider(mixed $provider, mixed $service = null): void
    {
        // Implement registerDeferredProvider() method.
    }

    /**
     * Get or set the request class for the application.
     *
     * @param string|null $class Optionally provide a class to use
     *
     */
    public static function requestClass(?string $class = null): string
    {
        if ($class !== null) {
            static::$requestClass = $class;
        }

        return static::$requestClass;
    }

    /**
     * Resolve a service provider instance from the class name.
     *
     * @param string|mixed $provider The provider class
     *
     */
    public function resolveProvider(mixed $provider): ServiceProvider
    {
        return app($provider);
    }

    /**
     * Get the path to the resources directory.
     *
     * @param string|mixed $path Add a relative path
     *
     */
    public function resourcePath(mixed $path = ''): string
    {
        return $this->basePath('resources/' . $path);
    }

    /**
     * Determine if the application routes are cached.
     *
     */
    public function routesAreCached(): bool
    {
        return false;
    }

    /**
     * Determine if the application is running in the console.
     *
     */
    public function runningInConsole(): mixed
    {
        return false;
    }

    /**
     * Determine if the application is running unit tests.
     *
     */
    public function runningUnitTests(): mixed
    {
        return true;
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath The base path to set
     *
     */
    public function setBasePath(string $basePath): self
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
    }

    /**
     * Set the environment
     *
     * @param string $env The environment
     *
     * @return Application
     */
    public function setEnvironment(string $env): self
    {
        $this->environment = $env;
        return $this;
    }

    /**
     * Set the current application locale.
     *
     * @param string|mixed $locale The locale
     *
     */
    public function setLocale(mixed $locale): void
    {
        //Implement setLocale() method.
    }

    /**
     * Determine if middleware has been disabled for the application.
     *
     */
    public function shouldSkipMiddleware(): bool
    {
        return true;
    }

    /**
     * Get the path to the storage directory.
     *
     */
    public function storagePath(): string
    {
        return ($this->storagePath) ?: $this->basePath . DIRECTORY_SEPARATOR . 'storage';
    }

    /**
     * Terminate the application.
     *
     */
    public function terminate(): void
    {
        //
    }

    /**
     * Get the version number of the application.
     *
     */
    public function version(): mixed
    {
        // Implement version
    }

    /**
     * Bind all of the application paths in the container.
     *
     */
    protected function bindPathsInContainer(): void
    {
        $this->instance('path', $this->path());
        $this->instance('path.base', $this->basePath());
        $this->instance('path.lang', $this->langPath());
        $this->instance('path.config', $this->configPath());
        $this->instance('path.public', $this->publicPath());
        $this->instance('path.storage', $this->storagePath());
        $this->instance('path.database', $this->databasePath());
        $this->instance('path.resources', $this->resourcePath());
        $this->instance('path.bootstrap', $this->bootstrapPath());
    }

    /**
     * Refresh the bound request instance in the container.
     *
     * @param Request $request The request instance
     *
     */
    protected function refreshRequest(Request $request): void
    {
        $this->instance('request', $request);

        Facade::clearResolvedInstance('request');
    }
}
