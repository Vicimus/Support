<?php

namespace Vicimus\Support\Testing;

use Illuminate\Auth\AuthManager;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Auth\GenericUser;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Cookie\CookieJar;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\DatabaseManager;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Hashing\BcryptHasher;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Pagination\Factory as PaginatorFactory;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\CacheBasedSessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ViewServiceProvider;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Translation\TranslatorInterface;
use Vicimus\Onyx\User;
use Vicimus\Support\Interfaces\Translator;

/**
 * Class DatabaseTestCase
 */
class ApplicationTestCase extends TestCase
{
    private static $application;

    private static $setupDatabase = false;

    /**
     * The application
     *
     * @var Application
     */
    protected $app;

    /**
     * The database path
     *
     * @var string
     */
    protected $database = ':memory:';

    /**
     * Migrations
     *
     * @var string[]
     */
    protected $migrations = [];

    /**
     * Base path for storage
     *
     * @var string
     */
    protected $path;

    /**
     * The paths
     * @var string[]
     */
    protected $paths = [];

    /**
     * Providers to load
     *
     * @var string[]
     */
    protected $providers = [];

    /**
     * The routes
     * @var string[]
     */
    protected $routes = [];

    /**
     * The testing client
     *
     * @var Client
     */
    private $client;

    /**
     * Act as a logged in user
     *
     * @param string $driver Driver to use
     * @param mixed  $user   User
     *
     * @return void
     */
    public function beSomebody($driver = null, $user = null)
    {
        if (!$user) {
            $user = new User();
        }

        $this->app['auth']->driver($driver)->setUser($user);
    }

    /**
     * Set up
     *
     * @return void
     */
    public function setup()
    {
        parent::setUp();
        $this->createApplication();
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        Facade::clearResolvedInstances();
    }

    /**
     * Do any additional bindings
     *
     * @param Application|mixed $app The application
     *
     * @return void
     */
    protected function bindings($app)
    {
        //
    }

    /**
     * Before tests are run
     *
     * @param Application|mixed $app The application
     *
     * @return void
     */
    protected function booted($app)
    {
        //
    }

    /**
     * Call the given URI and return the Response.
     *
     * @param  string $method        The method to use
     * @param  string $uri           The url to hit
     * @param  array  $parameters    Parameters to send
     * @param  array  $files         Files to send
     * @param  array  $server        Server values to send
     * @param  string $content       Body content
     * @param  bool   $changeHistory Change history
     *
     * @return mixed
     */
    protected function call($method, $uri, $parameters = [], $files = [], $server = [], $content = null, $changeHistory = true)
    {
        $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);
        return $this->client->getResponse();
    }

    /**
     * Create the testing application
     *
     * @return void
     */
    private function createApplication()
    {
        if (self::$application) {
            return $this->refreshApplication();
        }

        /** @var Application|mixed $app */
        $app = new Application();

        Facade::setFacadeApplication($app);

        $app->singleton('app', static function () use ($app) {
            return $app;
        });

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

        $app->bindShared('paginator', function ($app) {
            /** @var TranslatorInterface $translator */
            $translator = $this->getMockBuilder(TranslatorInterface::class)
                ->getMock();

            return new PaginatorFactory($app['request'], $app['view'], $translator);
        });

        $app->singleton('auth', static function ($app) {
            return new AuthManager($app);
        });

        $app->singleton('artisan', static function ($app) {
            return $app;
        });

        $app->singleton('cache', static function () {
            return new ArrayStore();
        });

        $app->bind('request', static function () {
            return new Request();
        });

        $app->bind('url', static function ($app) {
            /** @var Router $router */
            $router = $app['router'];
            $routes = $router->getRoutes();
            return new UrlGenerator($routes, $app['request']);
        });

        $app->singleton('events', static function ($container) {
            return new Dispatcher($container);
        });

        $app->bind('mailer', function () {
            return $this->getMockBuilder(Mailer::class)
                ->disableOriginalConstructor()
                ->getMock();
        });

        $app->bind('files', static function () {
            return new Filesystem();
        });

        $app->singleton('session.store', static function ($app) {
            return $app['session'];
        });

        $app->bind('cookie', static function () {
            return new CookieJar();
        });

        $app->singleton('session', static function () {
            $repo = new Repository(new ArrayStore());
            return new Store('testing', new CacheBasedSessionHandler($repo, 5));
        });

        $app->bind('redirect', static function ($app) {
            $redirector = new Redirector($app['url']);
            $redirector->setSession($app['session']);

            return $redirector;
        });

        $app->bind('translator', function () {
            return $this->getMockBuilder(\Illuminate\Contracts\Translation\Translator::class)
                ->getMock();
        });

        $app->bind(Translator::class, function () {
            return $this->getMockBuilder(Translator::class)->getMock();
        });


        $app->bind('hash', static function () {
            return new BcryptHasher();
        });

        $app->singleton('config', static function ($app) {
            $config = new ConfigRepository(new FileLoader($app['files'], __DIR__), 'testing');
            $config->set('view.paths', []);
            $config->set('auth.driver', 'eloquent');
            return $config;
        });

        $app->singleton('router', static function ($app) {
            return new Router($app['events'], $app);
        });

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

        $views->boot();
        foreach ($providers as $provider) {
            $provider->boot();
        }

        $this->app = $app;

        $stub = $this->database . '/stub.sqlite';
        $unsullied = $this->database . '/unsullied.sqlite';
        $testing = $this->database . '/testing.sqlite';

        @unlink($unsullied);
        @unlink($stub);
        touch($stub);

        @unlink($testing);
        touch($testing);

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

        $app->bind('db', static function () use ($capsule) {
            return $capsule->getDatabaseManager();
        });

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

                    /** @var mixed $instance */
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
        if (!filesize($unsullied)) {
            throw new \Exception('Database is 0 bytes. This is 99% an error');
        }

        self::$setupDatabase = true;

        copy($unsullied, $testing);

        foreach ($this->routes as $route) {
            require $route;
        }

        $this->booted($app);

        self::$application = $this->app;
        $this->client = new Client(static function ($verb, $payload) {
            return Application::onRequest($verb, $payload);
        }, $this->app);
    }

    /**
     * Refresh the application instead of creating a whole new instance.
     * This improves testing speeds by over 9000 percent
     *
     * @return void
     */
    private function refreshApplication()
    {
        $this->app = self::$application;
        $unsullied = $this->database . '/unsullied.sqlite';
        $testing = $this->database . '/testing.sqlite';

        copy($unsullied, $testing);
        Facade::setFacadeApplication($this->app);

        $this->client = new Client(static function ($verb, $payload) {
            return Application::onRequest($verb, $payload);
        }, $this->app);
    }
}