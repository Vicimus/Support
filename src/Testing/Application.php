<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Closure;
use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as LaravelApp;
use Illuminate\Support\ServiceProvider;

/**
 * Class Application
 *
 * phpcs:disable
 */
class Application extends Container implements LaravelApp
{

    /**
     * Get the base path of the Laravel installation.
     *
     * @return string|mixed|void
     */
    public function basePath()
    {
        // Implement basePath() method.
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
     * Get the version number of the application.
     *
     * @return string|mixed|void
     */
    public function version()
    {
        // Implement version
    }

    /**
     * Get the path to the bootstrap directory.
     *
     * @param string $path Optionally, a path to append to the bootstrap path
     *
     * @return string
     */
    public function bootstrapPath($path = '')
    {
        // TODO: Implement bootstrapPath() method.
    }

    /**
     * Get the path to the application configuration files.
     *
     * @param string $path Optionally, a path to append to the config path
     *
     * @return string
     */
    public function configPath($path = '')
    {
        // TODO: Implement configPath() method.
    }

    /**
     * Get the path to the database directory.
     *
     * @param string $path Optionally, a path to append to the database path
     *
     * @return string
     */
    public function databasePath($path = '')
    {
        // TODO: Implement databasePath() method.
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
        // TODO: Implement storagePath() method.
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
}}
