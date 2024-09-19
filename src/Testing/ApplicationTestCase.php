<?php

declare(strict_types=1);

namespace Vicimus\Support\Testing;

use Illuminate\Auth\AuthManager;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\CacheManager;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Cookie\CookieJar;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Mail\Mailer;
use Illuminate\Pagination\PaginationServiceProvider;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\CacheBasedSessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;
use Illuminate\View\ViewServiceProvider;
use PDO;
use PDOException;
use ReflectionException;
use ReflectionMethod;
use RuntimeException;
use stdClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Vicimus\Support\Exceptions\ValidationException;
use Vicimus\Support\Interfaces\Glovebox\Translator as VicimusTranslator;

class ApplicationTestCase extends TestCase
{
    private static Application $application;

    protected Application $app;

    protected string $basePath;

    protected string $database;

    /**
     * @var string[]
     */
    protected array $migrations = [];

    protected string $path;

    /**
     * @var string[]
     */
    protected array $paths = [];

    /**
     * @var string[]
     */
    protected array $providers = [];

    /**
     * @var string[]
     */
    protected array $routes = [];

    private Client $client;

    /**
     * Act as a logged in user
     */
    public function beSomebody(?string $driver = null, mixed $user = null): void
    {
        if (!$user) {
            $user = new stdClass();
            $user->email = 'testing@vicimus.com';
        }

        $this->app['auth']->driver($driver)->setUser($user);
    }

    public function setup(): void
    {
        parent::setUp();

        if (!$this->database) {
            $this->database = $this->path . '/database';
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        $this->createApplication();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        Facade::clearResolvedInstances();
    }

    protected function bindings(Application $app): void
    {
        //
    }

    protected function booted(Application $app): void
    {
        //
    }

    /**
     * Call the given URI and return the Response.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param  string  $method        The method to use
     * @param  string  $uri           The url to hit
     * @param  mixed[] $parameters    Parameters to send
     * @param  mixed[] $files         Files to send
     * @param  mixed[] $server        Server values to send
     * @param  string  $content       Body content
     * @param  bool    $changeHistory Change history
     *
     * @return SymfonyResponse|JsonResponse|Response
     */
    protected function call(
        string $method,
        string $uri,
        array $parameters = [],
        array $files = [],
        array $server = [],
        ?string $content = null,
        bool $changeHistory = true
    ): SymfonyResponse {
        try {
            $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
            $response = $this->client->getResponse();
        } catch (ValidationException $ex) {
            $response = new Response($ex->getMessage(), 422);
        }

        return $response;
    }

    /**
     * Boot providers
     *
     * @param ServiceProvider[] $providers Providers
     *
     *
     * @throws ReflectionException
     * @throws BindingResolutionException
     */
    private function boot(array $providers): void
    {
        foreach ($providers as $provider) {
            if (!method_exists($provider, 'boot')) {
                continue;
            }

            /** @phpcsSuppress SlevomatCodingStandard.Classes.ModernClassNameReference */
            $method = new ReflectionMethod($provider::class, 'boot');
            $params = [];
            foreach ($method->getParameters() as $param) {
                if (!$param->getType()) {
                    continue;
                }

                $params[] = app()->make($param->getType()->getName());
            }
            $provider->boot(...$params);
        }
    }

    /**
     * Create the testing application
     *
     *
     * @throws BindingResolutionException
     * @throws ReflectionException
     */
    private function createApplication(): void
    {
        if (self::$application) {
            $this->refreshApplication();
            return;
        }

        $app = new Application();
        Facade::setFacadeApplication($app);
        $app->setBasePath($this->basePath);

        $app->singleton('app', static fn () => $app);

        if ($this->path && !count($this->paths)) {
            foreach (['', 'storage', 'view', 'public', 'base'] as $part) {
                $this->paths[$part] = $this->path;
            }
        }

        foreach ($this->paths as $path => $value) {
            $second = $path;
            if ($second) {
                $second = '.' . $second;
            }

            $app->instance('path' . $second, $value);
        }

        $this->executeBindings($app);

        $pagination = new PaginationServiceProvider($app);
        $pagination->register();

        $views = new ViewServiceProvider($app);
        $views->register();

        /** @var ServiceProvider[] $providers */
        $providers = [];
        foreach ($this->providers as $provider) {
            $providers[] = new $provider($app);
        }

        foreach ($providers as $provider) {
            $provider->register();
        }

        $this->bindings($app);

        $this->boot($providers);

        $this->app = $app;
        $this->setDatabases($app);

        foreach ($this->routes as $route) {
            require $route;
        }

        $this->booted($app);

        self::$application = $this->app;
        $this->client = new Client(static fn ($verb, $payload) => Application::onRequest($verb, $payload), $this->app);
    }

    private function executeBindings(Application $app): void
    {
        $app->singleton('auth', static fn ($app) => new AuthManager($app));

        $app->singleton('artisan', static fn ($app) => $app);

        $app->singleton('cache', static fn () => new BasicCache());

        $app->singleton(CacheManager::class, static fn ($app) => new CacheManager($app));

        $app->bind('request', static fn () => new Request());

        $app->bind('url', static function ($app) {
            /** @var Router $router */
            $router = $app['router'];
            $routes = $router->getRoutes();
            return new UrlGenerator($routes, $app['request']);
        });

        $app->singleton('events', static fn ($container) => new Dispatcher($container));

        $app->bind('mailer', fn () => $this->getMockBuilder(Mailer::class)
                ->disableOriginalConstructor()
                ->getMock());

        $app->bind('files', static fn () => new Filesystem());

        $app->singleton('session.store', static fn ($app) => $app['session']);

        $app->bind('validator', static function ($app) {
            $factory = new Factory($app['translator'], $app);
            $factory->setPresenceVerifier(new DatabasePresenceVerifier($app['db']));
            return $factory;
        });

        $app->bind('cookie', static fn () => new CookieJar());

        $app->singleton('session', static function () {
            $repo = new CacheRepository(new ArrayStore());
            return new Store('testing', new CacheBasedSessionHandler($repo, 5));
        });

        $app->bind('redirect', static function ($app) {
            $redirector = new Redirector($app['url']);
            $redirector->setSession($app['session']);

            return $redirector;
        });

        $app->bind(
            'translator',
            fn () => $this->getMockBuilder(Translator::class)->disableOriginalConstructor()->getMock(),
        );

        $app->singleton('lang', static fn ($app) => $app['translator']);

        $app->bind('hash', static fn () => new BcryptHasher());

        $app->singleton('config', function () {
            $config = new ConfigRepository([]);
            $config->set('view.paths', []);
            $config->set('view.compiled', $this->path . '/views');
            $config->set('auth.driver', 'eloquent');
            return $config;
        });

        $app->singleton('router', static fn ($app) => new Router($app['events'], $app));

        $app->bind(
            VicimusTranslator::class,
            fn () => $this->getMockBuilder(VicimusTranslator::class)->disableOriginalConstructor()->getMock(),
        );
    }

    /**
     * Refresh the application instead of creating a whole new instance.
     * This improves testing speeds by over 9000 percent
     */
    private function refreshApplication(): void
    {
        $this->app = self::$application;
        $unsullied = $this->database . '/unsullied.sqlite';
        $testing = $this->database . '/testing.sqlite';

        copy($unsullied, $testing);
        Facade::setFacadeApplication($this->app);
        Facade::clearResolvedInstances();

        $this->client = new Client(static fn ($verb, $payload) => Application::onRequest($verb, $payload), $this->app);
    }

    /**
     * Set up the databases
     * @throws RuntimeException
     */
    private function setDatabases(Application $app): void
    {

        $stub = $this->database . '/stub.sqlite';
        $unsullied = $this->database . '/unsullied.sqlite';
        $testing = $this->database . '/testing.sqlite';

        // phpcs:disable
        @unlink($unsullied);
        @unlink($stub);
        touch($stub);

        @unlink($testing);
        touch($testing);

        // phpcs:enable

        $capsule = new Manager($app);
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => $stub,
            'prefix' => '',
        ], 'stub');

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => $unsullied,
            'prefix' => '',
        ], 'unsullied');

        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => $testing,
            'prefix' => '',
        ]);

        $capsule->setEventDispatcher($app['events']);
        $capsule->setFetchMode(PDO::FETCH_CLASS);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $app->singleton('db', static fn () => $capsule->getDatabaseManager());

        /** @var DatabaseManager $db */
        $db = app('db');
        $db->setDefaultConnection('stub');

        if (count($this->migrations)) {
            foreach ($this->migrations as $migrationPath) {
                $finder = (new Finder())->in($migrationPath)->sortByName();

                /** @var SplFileInfo $file */
                foreach ($finder->files() as $file) {
                    $matches = [];
                    preg_match('/class\s(.+?)\s/', $file->getContents(), $matches);
                    $class = $matches[1];

                    $instance = new $class();
                    try {
                        $instance->up();
                    } catch (PDOException $ex) {
                        throw $ex;
                    }
                }
            }
        }

        $db->setDefaultConnection('default');

        copy($stub, $unsullied);
        if (count($this->migrations) && !filesize($unsullied)) {
            throw new RuntimeException('Database is 0 bytes. This is 99% an error');
        }

        copy($unsullied, $testing);
    }
}
