<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Laravel\Lumen\Routing\Router;

/**
 * Adds a bit of flavour to the boring ass Lumen router
 */
class LumenRouter
{
    protected Router $app;

    public function __construct(Router $app)
    {
        $this->app = $app;
    }

    /**
     * Bind a delete route
     */
    public function delete(string $path, mixed $controller): void
    {
        $this->app->delete($path, $controller);
    }

    /**
     * Bind a get route
     */
    public function get(string $path, mixed $controller): void
    {
        $this->app->get($path, $controller);
    }

    /**
     * Bind a patch route
     */
    public function patch(string $path, mixed $controller): void
    {
        $this->app->patch($path, $controller);
    }

    /**
     * Bind a post route
     */
    public function post(string $path, mixed $controller): void
    {
        $this->app->post($path, $controller);
    }

    /**
     * Create a resource binding
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
     */
    protected function plural(string $resource): string
    {
        $resource = strtolower($resource);
        if (str_ends_with($resource, 's')) {
            return $resource;
        }

        return $resource . 's';
    }
}
