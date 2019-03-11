<?php

namespace Vicimus\Support\Testing;

use Illuminate\Container\Container;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Class Application
 */
class Application extends Container implements HttpKernelInterface
{
    /**
     * The request class used by the application.
     *
     * @var string
     */
    protected static $requestClass = Request::class;

    /**
     * Call a method on the default request class.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public static function onRequest($method, $parameters = array())
    {
        return forward_static_call_array(array(static::requestClass(), $method), $parameters);
    }

    /**
     * Get or set the request class for the application.
     *
     * @param  string  $class
     * @return string
     */
    public static function requestClass($class = null)
    {
        if ( ! is_null($class)) static::$requestClass = $class;

        return static::$requestClass;
    }

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
            $this->refreshRequest($request = Request::createFromBase($request));

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
     * Prepare the given value as a Response object.
     *
     * @param  mixed  $value
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function prepareResponse($value)
    {
        if ( ! $value instanceof SymfonyResponse) $value = new Response($value);

        return $value->prepare($this['request']);
    }
}
