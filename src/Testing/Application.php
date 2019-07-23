<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as LaravelApp;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application
 *
 * phpcs:disable
 */
class Application extends Container implements LaravelApp, HttpKernelInterface
{

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
     * The custom storage path defined by the developer.
     *
     * @var string
     */
    protected $storagePath;

    /**
     * The custom environment path defined by the developer.
     *
     * @var string
     */
    protected $environmentPath;


    public function __construct(string $basePath = null)
    {
        if ($basePath) {
            $this->setBasePath($basePath);
        }
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
     * Get the base path of the Laravel installation.
     *
     * @param  string  $path Optionally, a path to append to the base path
     * @return string
     */
    public function basePath($path = '')
    {
        return realpath($this->basePath.($path ? DIRECTORY_SEPARATOR.$path : $path));
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @param  string  $path Optionally, a path to append to the bootstrap path
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'bootstrap'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param  string  $path Optionally, a path to append to the config path
     * @return string
     */
    public function configPath($path = '')
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'config'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Get the path to the database directory.
     *
     * @param  string  $path Optionally, a path to append to the database path
     * @return string
     */
    public function databasePath($path = '')
    {
        return ($this->databasePath ?: $this->basePath.DIRECTORY_SEPARATOR.'database').($path ? DIRECTORY_SEPARATOR.$path : $path);
    }


    /**
     * Register a new boot listener.
     *
     * @param mixed $callback The callback
     *
     * @return void|mixed
     */
    public function booting($callback)
    {
        // Implement booting() method.
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
        return 'testing';
    }

    /**
     * Get the path to the cached packages.php file.
     *
     * @return string|mixed|void
     */
    public function getCachedPackagesPath()
    {
        // Implement getCachedPackagesPath() method.
    }

    /**
     * Get the path to the cached services.php file.
     *
     * @return string|mixed|void
     */
    public function getCachedServicesPath()
    {
        // Implement getCachedServicesPath() method.
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
     * Register a service provider with the application.
     *
     * @param  ServiceProvider|string $provider The provider
     * @param  bool|mixed             $force    Force
     *
     * @return ServiceProvider|mixed|void
     */
    public function register($provider, $force = false)
    {
        // Implement register() method when necessary
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
     * @param  string|mixed $provider The providers
     * @param  string|null  $service  The service
     *
     * @return void|mixed
     */
    public function registerDeferredProvider($provider, $service = null)
    {
        // Implement registerDeferredProvider() method.
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
     * @param  string  $basePath
     * @return self
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, '\/');

        $this->bindPathsInContainer();

        return $this;
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
     * Get the path to the environment file directory.
     *
     * @return string
     */
    public function environmentPath()
    {
        // TODO: Implement environmentPath() method.
    }

    /**
     * Get the path to the resources directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function resourcePath($path = '')
    {
        // TODO: Implement resourcePath() method.
    }

    /**
     * Get the path to the storage directory.
     *
     * @return string
     */
    public function storagePath()
    {
        return $this->storagePath ?: $this->basePath.DIRECTORY_SEPARATOR.'storage';
    }

    /**
     * Resolve a service provider instance from the class name.
     *
     * @param string $provider
     *
     * @return \Illuminate\Support\ServiceProvider
     */
    public function resolveProvider($provider)
    {
        // TODO: Implement resolveProvider() method.
    }

    /**
     * Run the given array of bootstrap classes.
     *
     * @param array $bootstrappers
     *
     * @return void
     */
    public function bootstrapWith(array $bootstrappers)
    {
        // TODO: Implement bootstrapWith() method.
    }

    /**
     * Determine if the application configuration is cached.
     *
     * @return bool
     */
    public function configurationIsCached()
    {
        // TODO: Implement configurationIsCached() method.
    }

    /**
     * Detect the application's current environment.
     *
     * @param \Closure $callback
     *
     * @return string
     */
    public function detectEnvironment(Closure $callback)
    {
        // TODO: Implement detectEnvironment() method.
    }

    /**
     * Get the environment file the application is using.
     *
     * @return string
     */
    public function environmentFile()
    {
        // TODO: Implement environmentFile() method.
    }

    /**
     * Get the fully qualified path to the environment file.
     *
     * @return string
     */
    public function environmentFilePath()
    {
        // TODO: Implement environmentFilePath() method.
    }

    /**
     * Get the path to the configuration cache file.
     *
     * @return string
     */
    public function getCachedConfigPath()
    {
        // TODO: Implement getCachedConfigPath() method.
    }

    /**
     * Get the path to the routes cache file.
     *
     * @return string
     */
    public function getCachedRoutesPath()
    {
        // TODO: Implement getCachedRoutesPath() method.
    }

    /**
     * Get the current application locale.
     *
     * @return string
     */
    public function getLocale()
    {
        // TODO: Implement getLocale() method.
    }

    /**
     * Get the application namespace.
     *
     * @return string
     *
     * @throws \RuntimeException
     */
    public function getNamespace()
    {
        // TODO: Implement getNamespace() method.
    }

    /**
     * Get the registered service provider instances if any exist.
     *
     * @param \Illuminate\Support\ServiceProvider|string $provider
     *
     * @return array
     */
    public function getProviders($provider)
    {
        // TODO: Implement getProviders() method.
    }

    /**
     * Determine if the application has been bootstrapped before.
     *
     * @return bool
     */
    public function hasBeenBootstrapped()
    {
        // TODO: Implement hasBeenBootstrapped() method.
    }

    /**
     * Load and boot all of the remaining deferred providers.
     *
     * @return void
     */
    public function loadDeferredProviders()
    {
        // TODO: Implement loadDeferredProviders() method.
    }

    /**
     * Set the environment file to be loaded during bootstrapping.
     *
     * @param string $file
     *
     * @return LaravelApp
     */
    public function loadEnvironmentFrom($file)
    {
        // TODO: Implement loadEnvironmentFrom() method.
    }

    /**
     * Determine if the application routes are cached.
     *
     * @return bool
     */
    public function routesAreCached()
    {
        // TODO: Implement routesAreCached() method.
    }

    /**
     * Set the current application locale.
     *
     * @param string $locale
     *
     * @return void
     */
    public function setLocale($locale)
    {
        // TODO: Implement setLocale() method.
    }

    /**
     * Determine if middleware has been disabled for the application.
     *
     * @return bool
     */
    public function shouldSkipMiddleware()
    {
        // TODO: Implement shouldSkipMiddleware() method.
    }

    /**
     * Terminate the application.
     *
     * @return void
     */
    public function terminate(){
 // TODO: Implement terminate() method.
}

    /**
     * Handle the given request and get the response.
     *
     * Provides compatibility with BrowserKit functional testing.
     *
     * @implements HttpKernelInterface::handle
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @param  int   $type
     * @param  bool  $catch
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function handle(SymfonyRequest $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        try
        {
            $this->refreshRequest($request = \Illuminate\Http\Request::createFromBase($request));

            $this->boot();

            return $this->dispatch($request);
        }
        catch (\Exception $e)
        {
            if ( ! $catch || $this->runningUnitTests()) throw $e;

            return $this['exception']->handleException($e);
        }
        catch (\Throwable $e)
        {
            if ( ! $catch || $this->runningUnitTests()) throw $e;

            return $this['exception']->handleException($e);
        }
    }

    /**
     * Refresh the bound request instance in the container.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function refreshRequest(Request $request)
    {
        $this->instance('request', $request);

        Facade::clearResolvedInstance('request');
    }

    /**
     * Handle the given request and get the response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function dispatch(Request $request)
    {
        if ($this->isDownForMaintenance())
        {
            $response = $this['events']->until('illuminate.app.down');

            if ( ! is_null($response)) return $this->prepareResponse($response, $request);
        }

        if ($this->runningUnitTests() && ! $this['session']->isStarted())
        {
            $this['session']->start();
        }

        return $this['router']->dispatch($this->prepareRequest($request));
    }

    /**
     * Prepare the request by injecting any services.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Request
     */
    public function prepareRequest(Request $request)
    {
        if ( ! is_null($this['config']['session.driver']) && ! $request->hasSession())
        {
            $request->setSession($this['session']->driver());
        }

        return $request;
    }

    /**
     * Prepare the given value as a Response object.
     *
     * @param  mixed  $value
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prepareResponse($value)
    {
        if ( ! $value instanceof SymfonyResponse) $value = new \Illuminate\Http\Response($value);

        return $value->prepare($this['request']);
    }

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'public';
    }

    /**
     * Get the path to the language files.
     *
     * @return string
     */
    public function langPath()
    {
        return $this->resourcePath().DIRECTORY_SEPARATOR.'lang';
    }

    /**
     * Get the path to the application "app" directory.
     *
     * @param  string  $path
     * @return string
     */
    public function path($path = '')
    {
        $appPath = $this->appPath ?: $this->basePath.DIRECTORY_SEPARATOR.'app';

        return $appPath.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
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
}
