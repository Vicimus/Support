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
 * This is phpcs disabled because it's an extension of Laravel's application which does
 * not typehint properly, and it would just be a massive headache trying to make our implementation
 * meet our coding standards while not breaking it.
 *
 * @phpcs:disable
 */
class Application extends Container implements LaravelApp, HttpKernelInterface
{
    /**
     * The request class used by the application.
     *
     * @var string
     */
    protected static $requestClass = Request::class;

    /**
     * The custom application path defined by the developer.
     *
     * @var string
     */
    protected $appPath;

    /**
     * The custom database path defined by the developer.
     *
     * @var string
     */
    protected $databasePath;

    /**
     * The custom environment path defined by the developer.
     *
     * @var string
     */
    protected $environmentPath;

    /**
     * Providers
     * @var string[]
     */
    protected $providers = [];

    /**
     * The custom storage path defined by the developer.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * Testing
     * @var string
     */
    private $environment = 'testing';

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
     * @return string
     */
    public function basePath($path = ''): string
    {
        return realpath($this->basePath.(($path) ? DIRECTORY_SEPARATOR.$path : $path));
    }

    /**
     * Boot the application's service providers.
     *
     * @return void|mixed
     */
    public function boot()
    {
        //  Implement boot() method.
    }

    /**
     * Register a new "booted" listener.
     *
     * @param mixed $callback The callback
     *
     * @return void|mixed
     */
    public function booted($callback)
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
    public function booting($callback): void
    {
        // Implement booting() method.
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @param string|mixed $path Optionally, a path to append to the bootstrap path
     *
     * @return string
     */
    public function bootstrapPath($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.(($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Run the given array of bootstrap classes.
     *
     * @param mixed[] $classes Array of bootstrap classes
     *
     * @return void
     */
    public function bootstrapWith(array $bootstrappers): void
    {
        // Implement bootstrapWith() method.
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string|mixed $path Optionally, a path to append to the config path
     *
     * @return string
     */
    public function configPath($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.(($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }


    /**
     * Determine if the application configuration is cached.
     *
     * @return bool
     */
    public function configurationIsCached(): bool
    {
        return false;
    }

    /**
     * Get the path to the database directory.
     *
     * @param string|mixed $path Optionally, a path to append to the database path
     * @return string
     */
    public function databasePath($path = ''): string
    {
        return (($this->databasePath) ?: $this->basePath.DIRECTORY_SEPARATOR.'database') .
            (($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Detect the application's current environment.
     *
     * @param Closure $callback Closure to detect environment
     *
     * @return string
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
     * @return Response
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
     * @return string|mixed
     */
    public function environment(...$environments)
    {
        if (!count($environments)) {
            return $this->environment;
        }

        return in_array($this->environment, $environments, false);
    }

    /**
     * Get the environment file the application is using.
     *
     * @return string
     */
    public function environmentFile(): string
    {
        return $this->basePath('.env');
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath(): string
    {
        return $this->basePath('.env');
    }

    /**
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath(): string
    {
        return $this->basePath();
    }

    /**
     * Get the path to the configuration cache file.
     *
     * @return string
     */
    public function getCachedConfigPath(): string
    {
        return $this->storagePath() . '/cache';
    }

    /**
     * Get the path to the cached packages.php file.
     *
     * @return string|mixed|void
     */
    public function getCachedPackagesPath()
    {
        return $this->storagePath() . '/cache';
    }

    /**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedRoutesPath(): string
    {
        return $this->storagePath . '/cache';
    }

    /**
     * Get the path to the cached services.php file.
     *
     * @return string|mixed|void
     */
    public function getCachedServicesPath()
    {
        return $this->storagePath() . '/cache';
    }

    /**
     * Get the current application locale.
     *
     * @return string
     */
    public function getLocale(): string
    {
        return 'en';
    }

    /**
     * Get the application namespace.
     *
     * @return string
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
     * @return Response
     *
     * @throws Throwable
     */
    public function handle(
        SymfonyRequest $request,
        $type = HttpKernelInterface::MASTER_REQUEST,
        $catch = true
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
     * @return bool
     */
    public function hasBeenBootstrapped(): bool
    {
        return true;
    }

    public function hasDebugModeEnabled()
    {
        return true;
    }

    /**
     * Determine if the application is currently down for maintenance.
     *
     * @return bool|mixed
     */
    public function isDownForMaintenance()
    {
        return false;
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath($path = ''): string
    {
        return $this->resourcePath().DIRECTORY_SEPARATOR.'lang';
    }

    /**
     * Load and boot all of the remaining deferred providers.
     *
     * @return void
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
     * @return self
     */
    public function loadEnvironmentFrom($file): self
    {
        return $this;
    }

    public function maintenanceMode()
    {
        // TODO: Implement maintenanceMode() method.
    }

    /**
     * Call a method on the default request class.
     *
     * @param string  $method     The method
     * @param mixed[] $parameters Parameters
     *
     * @return mixed
     */
    public static function onRequest(string $method, array $parameters = [])
    {
        return forward_static_call_array([static::requestClass(), $method], $parameters);
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @param string $path The path to get
     *
     * @return string
     */
    public function path(string $path = ''): string
    {
        $appPath = ($this->appPath) ?: $this->basePath.DIRECTORY_SEPARATOR.'app';
        return $appPath.(($path) ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Prepare the request by injecting any services.
     *
     * @param Request $request The request instance
     *
     * @return Request
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
     * @return Response
     */
    public function prepareResponse($value): Response
    {
        if (!$value instanceof SymfonyResponse) {
            $value = new IlluminateResponse($value);
        }

        return $value->prepare($this['request']);
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath($path = ''): string
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
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
     * @return void|mixed
     */
    public function registerConfiguredProviders()
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
    public function registerDeferredProvider($provider, $service = null): void
    {
        // Implement registerDeferredProvider() method.
    }

    /**
     * Get or set the request class for the application.
     *
     * @param string|null $class Optionally provide a class to use
     *
     * @return string
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
     * @return ServiceProvider
     */
    public function resolveProvider($provider): ServiceProvider
    {
        return app($provider);
    }

    /**
     * Get the path to the resources directory.
     *
     * @param string|mixed $path Add a relative path
     *
     * @return string
     */
    public function resourcePath($path = ''): string
    {
        return $this->basePath('resources/' . $path);
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    public function routesAreCached(): bool
    {
        return false;
    }

    /**
     * Determine if the application is running in the console.
     *
     * @return bool|mixed
     */
    public function runningInConsole()
    {
        return false;
    }

    /**
     * Determine if the application is running unit tests.
     *
     * @return bool|mixed
     */
    public function runningUnitTests()
    {
        return true;
    }

    /**
     * Set the base path for the application.
     *
     * @param string $basePath The base path to set
     *
     * @return self
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
     * @return void
     */
    public function setLocale($locale): void
    {
        //Implement setLocale() method.
    }

    /**
     * Determine if middleware has been disabled for the application.
     *
     * @return bool
     */
    public function shouldSkipMiddleware(): bool
    {
        return true;
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath($path = ''): string
    {
        return ($this->storagePath) ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }

    /**
     * Terminate the application.
     *
     * @return void
     */
    public function terminate(): void
    {
        //
    }

    public function terminating($callback)
    {
        // TODO: Implement terminating() method.
    }

    /**
     * Get the version number of the application.
     *
     * @return string|mixed|void
     */
    public function version()
    {
        // Implement version
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
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
     * @return void
     */
    protected function refreshRequest(Request $request): void
    {
        $this->instance('request', $request);

        Facade::clearResolvedInstance('request');
    }
}
