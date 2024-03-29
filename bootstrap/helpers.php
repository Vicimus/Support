<?php declare(strict_types = 1);

use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Session\SessionManager;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Response;
use Vicimus\Support\Database\ModelFactory;
use Vicimus\Support\Database\ModelFactoryBuilder;
use Vicimus\Support\Exceptions\TranslationFileException;
use Vicimus\Support\Interfaces\Translator;
use Vicimus\Support\Services\Responses;

if (!function_exists('___')) {
    /**
     * Translate the given message.
     *
     * @param string   $key     The translation file key
     * @param string   $default The default value
     * @param string[] $replace The array of variables
     * @param string   $locale  The locale
     *
     * @return string|string[]|null
     *
     * phpcs:disable
     */
    function ___(string $key, ?string $default = null, array $replace = [], ?string $locale = null)
    {
        $result = __($key, $replace, $locale);
        if ($result === $key) {
            if (strpos($default ?? '', ':') === false) {
                return $default;
            }

            foreach ($replace as $search => $instance) {
                $default = str_replace(':' . $search, $instance, $default);
            }

            return $default;
        }

        return $result;
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
        // This is real dirty but it works so come at me/
        // Improves loading speed of larger pages (inventory, etc) by around 33%
        global $__LOCALE;
        if (!$__LOCALE) {
            $__LOCALE = app()->getLocale();
        }

        if ($__LOCALE === 'en' && $default && !count($variables)) {
            return $default;
        }

        $hash = md5(sprintf('%s_%s', $key, json_encode($variables)));
        if (\Illuminate\Support\Facades\Cache::has($hash)) {
            return \Illuminate\Support\Facades\Cache::get($hash);
        }

        /** @var Translator $translator */
        $translator = app(Translator::class);
        $result = $default;
        try {
            $result = $translator->tran($key, $default, $variables);
        } catch (TranslationFileException $ex) {
            $result = $default;
        }

        \Illuminate\Support\Facades\Cache::put($hash, $result);
        return $result;
    }
}

if (defined('LARAVEL_START')) {
    return;
}

if (!function_exists('lang')) {
    function lang()
    {
        return app('translator');
    }
}

if (!function_exists('factory')) {
    /**
     * @param string|null $class The class to create
     * @param int|null    $count The number to create
     *
     * @return ModelFactoryBuilder|ModelFactory
     */
    function factory($class = null, $count = null)
    {
        /** @var ModelFactory $factory */
        $factory = app('factory');
        if ($class === null) {
            return $factory;
        }

        return $factory->builder($class, $count);
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
     * @param mixed|null   $default  The default value to use
     *
     * @return Repository|mixed
     */
    function config($property = null, $default = null)
    {
        /** @var Illuminate\Config\Repository $config */
        $config = app('config');
        if ($property) {
            $value = $config->get($property, $default);
            if (is_numeric($value)) {
                return (int) $value;
            }

            if ($value === 'false') {
                return false;
            }

            if ($value === 'true') {
                return true;
            }

            return $value;
        }

        return app('config');
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
     * @param mixed             $default  Default to use
     *
     * @return \Illuminate\Http\Request|mixed
     */
    function request($property = null, $default = null)
    {
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
