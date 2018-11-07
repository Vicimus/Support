<?php declare(strict_types = 1);

namespace Vicimus\Support\Testing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Foundation\Application as LaravelApp;
use Illuminate\Support\ServiceProvider;

/**
 * Class Application
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
     * @return string|mixed
     */
    public function environment()
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
        return true;
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
}
