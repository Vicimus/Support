<?php

use DealerLive\Config\Services\Configuration;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Vicimus\Support\Exceptions\TranslationFileException;
use Vicimus\Support\Interfaces\Translator;
use Vicimus\Support\Services\Responses;

if (!function_exists('lang')) {
    function lang() {
        return app('lang');
    }
}

if (!function_exists('env')) {
    /**
     * Get an environmental value or the default passed if no value found
     *
     * @param string $key     The key to find
     * @param string $default The value to return if no value found
     *
     * @return string
     */
    function env($key, $default = null)
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
     * @return mixed
     */
    function config($property)
    {
        return Config::get($property);
    }
}

if (!function_exists('view')) {
    /**
     * @param string|mixed $path   The path to the view
     * @param mixed[]      $params The parameters to pass
     *
     * @return Illuminate\View\View|\Illuminate\View\Factory|mixed
     */
    function view($path = null, array $params = [])
    {
        if ($path === null) {
            return app('view');
        }

        return app('view')->make($path, $params);
    }
}


if (!function_exists('response')) {
    /**
     * @param mixed     $response The response to send
     * @param int|mixed $code     The http code to use
     *
     * @return \Illuminate\Http\Response|ResponseFactory|mixed
     */
    function response($response = null, $code = 200)
    {
        if ($response === null) {
            return new Responses();
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
     * @param string|null|mixed $property Get the property
     *
     * @return \Illuminate\Http\Request|mixed
     */
    function request($property = null)
    {
        if (!$property) {
            return app('request');
        }

        return app('request')->get($property);
    }
}

if (!function_exists('event')) {
    /**
     * Fire an event or get the event dispatcher
     *
     * @param string $event   The event name
     * @param mixed  $payload The payload to send with the event
     *
     * @return \Illuminate\Events\Dispatcher|mixed
     */
    function event($event = null, $payload = null)
    {
        if ($event === null) {
            return app('events');
        }

        return app('events')->fire($event, $payload);
    }
}

if (!function_exists('setting')) {
    /**
     * Check a config setting
     *
     * @param string $property The property to check
     *
     * @return Configuration|mixed
     */
    function setting($property = null, $default = null)
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
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse|mixed
     */
    function redirect($url = null)
    {
        /** @var \Illuminate\Routing\Redirector $redirector */
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
     * @return \Carbon\Carbon
     */
    function now()
    {
        return Carbon\Carbon::now();
    }
}

if (!function_exists('tran')) {
    /**
     * Auto-write to translation files
     *
     * @param string|mixed $key       The key to look for
     * @param string|mixed $default   The default to use
     * @param mixed[]      $variables Variable placeholders
     *
     * @return mixed
     */
    function tran($key, $default = null, array $variables = [])
    {
        /** @var Translator $translator */
        $translator = app(Translator::class);
        try {
            return $translator->tran($key, $default, $variables);
        } catch (TranslationFileException $ex) {
            return $default;
        }
    }
}

if (!function_exists('validate')) {
    /**
     * Validate
     *
     * @param array                         $rules
     * @param \Illuminate\Http\Request|null $request
     */
    function validate(array $rules, \Illuminate\Http\Request $request = null)
    {
        if ($request === null) {
            $request = request();
        }

        /** @var \Illuminate\Contracts\Validation\Factory $factory */
        $factory = app('validator');
        $validator = $factory->make($request->all(), $rules);
        if ($validator->fails()) {
            $message = sprintf('Missing required fields [%s]', implode(', ', array_keys($validator->errors()->getMessages())));
            throw new \Vicimus\Support\Exceptions\ValidationException($message);
        }
    }
}
