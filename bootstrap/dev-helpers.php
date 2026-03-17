<?php declare(strict_types = 1);

use Carbon\Carbon;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\Translation\Translator as TranslatorContract;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Factory as EloquentFactory;
use Illuminate\Database\Eloquent\FactoryBuilder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Vicimus\Support\Exceptions\TranslationFileException;
use Vicimus\Support\Interfaces\Glovebox\Configuration;
use Vicimus\Support\Interfaces\Glovebox\Translator;
use Vicimus\Support\Services\Responses;
use Vicimus\Support\Testing\Application;

if (!function_exists('app')) {
    /**
     * Get the root Facade application instance.
     *
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @param string $make Make an instance of this class
     *
     * @return Application|Container|mixed
     */
    function app(?string $make = null)
    {
        $app = Illuminate\Support\Facades\Facade::getFacadeApplication() ?? Application::getInstance();
        if ($make) {
            /** @noinspection PhpUnhandledExceptionInspection */
            return $app->make($make);
        }

        return $app;
    }
}

if (!function_exists('url')) {
    /**
     * Generate a url for the application.
     *
     * @param string $path       The path
     * @param mixed  $parameters The parameters
     * @param bool   $secure     Secure
     *
     * @return string
     */
    function url(?string $path = null, $parameters = [], ?bool $secure = null): string
    {
        return app('url')->to($path, $parameters, $secure);
    }
}

if (!function_exists('lang')) {
    /**
     * Get a translator instance
     *
     * @return TranslatorContract
     */
    function lang(): TranslatorContract
    {
        return app('translator');
    }
}

if (!function_exists('env')) {
    /**
     * Get an environmental value or the default passed if no value found
     *
     * @param string $key     The key to find
     * @param mixed  $default The value to return if no value found
     *
     * @return string|int|bool
     */
    function env(string $key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }

        return $value;
    }
}

if (!function_exists('config')) {
    /**
     * Mirrors Laravel 5+ config method
     *
     * @param string|mixed $property The config property to get
     *
     * @return Repository|mixed
     */
    function config($property = null)
    {
        if ($property) {
            return Config::get($property);
        }

        return app('config');
    }
}

if (!function_exists('view')) {
    /**
     * @param string|mixed $path   The path to the view
     * @param mixed[]      $params The parameters to pass
     *
     * @return ViewFactory|View
     */
    function view($path = null, array $params = [])
    {
        /** @var ViewFactory $factory */
        $factory = app('view');
        if ($path === null) {
            return $factory;
        }

        return $factory->make($path, $params);
    }
}

if (!function_exists('response')) {
    /**
     * @param string|mixed $response The response to send
     * @param int          $code     The http code to use
     *
     * @return \Illuminate\Http\Response|ResponseFactory|mixed
     */
    function response($response = null, int $code = 200)
    {
        if ($response === null) {
            return new Responses(app('view'));
        }

        return Response::make($response, $code);
    }
}

if (!function_exists('session')) {
    /**
     * Get a session value or the session manager
     *
     * @param string|mixed|null $property Ask for a property
     * @param string|mixed|null $default  A default value
     *
     * @return SessionManager|Store|mixed
     */
    function session($property = null, $default = null)
    {
        /** @var SessionManager|Store $session */
        $session = app('session');
        if (!$property) {
            return $session;
        }

        return $session->get($property, $default);
    }
}

if (!function_exists('request')) {
    /**
     * Get the request instance
     *
     * @param string|null $property Get the property
     * @param mixed       $default  Default to use
     *
     * @return Request|mixed
     */
    function request(?string $property = null, $default = null)
    {
        /** @var Request $request */
        $request = app('request');
        if (!$property) {
            return $request;
        }

        return $request->get($property, $default);
    }
}

if (!function_exists('event')) {
    /**
     * Fire an event or get the event dispatcher
     *
     * @param mixed|string $event   The event name
     * @param mixed        $payload The payload to send with the event
     *
     * @return Dispatcher|mixed[]
     */
    function event($event = null, $payload = null)
    {
        /** @var Dispatcher $dispatcher */
        $dispatcher = app('events');
        if ($event === null) {
            return $dispatcher;
        }

        return $dispatcher->dispatch($event, $payload);
    }
}

if (!function_exists('setting')) {
    /**
     * Check a config setting
     *
     * @param string     $property The property to check
     * @param string|int $default  The default value to use
     *
     * @return Configuration|mixed
     */
    function setting(?string $property = null, $default = null)
    {
        /** @var Configuration $service */
        $service = app(Configuration::class);
        if (!$property) {
            return $service;
        }

        $result = $service->check($property);
        if ($result === null) {
            return $default;
        }

        return $result;
    }
}

if (!function_exists('redirect')) {
    /**
     * @param string $url The url to redirect to
     *
     * @return Redirector|RedirectResponse|mixed
     */
    function redirect(?string $url = null)
    {
        /** @var Redirector $redirector */
        $redirector = app('redirect');
        if ($url === null) {
            return $redirector;
        }

        return $redirector->to($url);
    }
}

if (!function_exists('now')) {
    /**
     * Get now
     *
     * @return Carbon
     */
    function now(): Carbon
    {
        return Carbon::now();
    }
}

if (!function_exists('validate')) {
    /**
     * Validate
     *
     * @param string[]     $rules   The rules to use to validate
     * @param Request|null $request The request instance
     *
     * @return void
     *
     * @throws ValidationException
     */
    function validate(array $rules, ?Request $request = null): void
    {
        if ($request === null) {
            $request = request();
        }

        /** @var \Illuminate\Contracts\Validation\Factory $factory */
        $factory = app('validator');
        $validator = $factory->make($request->all(), $rules);
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the public path
     *
     * phpcs:disable Generic.NamingConventions.CamelCapsFunctionName.NotCamelCaps
     *
     * @param string|null $relative Add a relative path to it
     *
     * @return string
     */
    function public_path(?string $relative = null): string
    {
        return app('path.public') . DIRECTORY_SEPARATOR . $relative;
    }
}

if (!function_exists('storage_path')) {
    /**
     * Get the storage path
     *
     * @param string|null $relative Add a relative path to it
     *
     * @return string
     */
    function storage_path(?string $relative = null): string
    {
        return app('path.storage') . DIRECTORY_SEPARATOR . $relative;
    }
}

if (!function_exists('resource_path')) {
    /**
     * Get the storage path
     *
     * @param string|null $relative Add a relative path to it
     *
     * @return string
     */
    function resource_path(?string $relative = null): string
    {
        return app('path.resource') . DIRECTORY_SEPARATOR . $relative;
    }
}


if (!function_exists('app_path')) {
    /**
     * Get the app path
     *
     * @param string|null $relative Add a relative path to it
     *
     * @return string
     */
    function app_path(?string $relative = null): string
    {
        return app('path.app') . DIRECTORY_SEPARATOR . $relative;
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the app path
     *
     * @param string|null $relative Add a relative path to it
     *
     * @return string
     */
    function base_path(?string $relative = null): string
    {
        return app('path.base') . DIRECTORY_SEPARATOR . $relative;
    }
}

if (!function_exists('database_path')) {
    /**
     * Get the app path
     *
     * @param string|null $relative Add a relative path to it
     *
     * @return string
     */
    function database_path(?string $relative = null): string
    {
        return app('path.database') . DIRECTORY_SEPARATOR . $relative;
    }
}

if (!function_exists('config_path')) {
    /**
     * Get the config path
     *
     * @param string|null $relative The relative path to add to it
     *
     * @return string
     */
    function config_path(?string $relative = null): string
    {
        return app('path.config') . DIRECTORY_SEPARATOR . $relative;
    }
}


if (! function_exists('route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param string[]|string $name       Name or names of the routes
     * @param mixed           $parameters Parameters
     * @param bool            $absolute   Absolute
     *
     * @return string
     */
    function route($name, $parameters = [], bool $absolute = true): string
    {
        return app('url')->route($name, $parameters, $absolute);
    }
}

if (! function_exists('factory')) {
    /**
     * Create a model factory builder for a given class, name, and amount.
     *
     * @return FactoryBuilder
     */
    function factory(): FactoryBuilder
    {
        $factory = app(EloquentFactory::class);

        $arguments = func_get_args();

        if (isset($arguments[1]) && is_string($arguments[1])) {
            return $factory->of($arguments[0], $arguments[1])->times($arguments[2] ?? null);
        }

        if (isset($arguments[1])) {
            return $factory->of($arguments[0])->times($arguments[1]);
        }

        return $factory->of($arguments[0]);
    }
}
