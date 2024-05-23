<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Laravel\Lumen\Application;
use Laravel\Lumen\Routing\Router;

/**
 * Adds a bit of flavour to the boring ass Lumen router
 */
class LumenRouter
{
    /**
     * Holds the Lumen application
     *
     */
    protected Application $app;

    /**
     * Pass in the application instance
     *
     * @param Router $app The application router
     */
    public function __construct(Router $app)
    {
        $this->app = $app;
    }

    /**
     * Bind a delete route
     *
     * @param string $path       The path
     * @param mixed  $controller The controller and method to handle it
     *
     */
    public function delete(string $path, mixed $controller): void
    {
        $this->app->delete($path, $controller);
    }

    /**
     * Bind a get route
     *
     * @param string $path       The path
     * @param mixed  $controller The controller and method to handle it
     *
     */
    public function get(string $path, mixed $controller): void
    {
        $this->app->get($path, $controller);
    }

    /**
     * Bind a patch route
     *
     * @param string $path       The path
     * @param mixed  $controller The controller and method to handle it
     *
     */
    public function patch(string $path, mixed $controller): void
    {
        $this->app->patch($path, $controller);
    }

    /**
     * Bind a post route
     *
     * @param string $path       The path
     * @param mixed  $controller The controller and method to handle it
     *
     */
    public function post(string $path, mixed $controller): void
    {
        $this->app->post($path, $controller);
    }

    /**
     * Create a resource binding
     *
     * @param string $resource   The resource to bind
     * @param string $controller The name of the controller that will handle
     *
     */
    public function resource(string $resource, string $controller): void
    {
        $base = $this->plural($resource);
        $entity = '/{' . $resource . '}';

        $this->app->get($base, $controller . '@index');
        $this->app->post($base, $controller . '@store');
        $this->app->get($base . $entity, $controller . '@show');
        $this->app->patch($base . $entity, $controller . '@update');
        $this->app->delete($base . $entity, $controller . '@destroy');
    }

    /**
     * Get the plural form of the resource
     *
     * @param string $resource The resource
     *
     */
    protected function plural(string $resource): string
    {
        $resource = strtolower($resource);
        if (substr($resource, -1) === 's') {
            return $resource;
        }

        return $resource . 's';
    }
}
