<?php

namespace Vicimus\Support\Testing;

use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Illuminate\Config\FileLoader;
use Illuminate\Config\Repository as ConfigRepository;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Pagination\Factory as PaginatorFactory;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Router;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Session\CacheBasedSessionHandler;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\ViewServiceProvider;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\Translation\TranslatorInterface;
use Vicimus\Support\Interfaces\Translator;

/**
 * Class DatabaseTestCase
 */
class ApplicationTestCase extends TestCase
{
    /**
     * The application
     *
     * @var Application
     */
    protected $app;

    /**
     * Migrations
     *
     * @var string[]
     */
    protected $migrations = [];

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
     * Set up
     *
     * @return void
     */
    public function setup()
    {
        parent::setUp();

        /** @var Application|mixed $app */
        $app = new Application();

        Facade::setFacadeApplication($app);

        $app->bind('app', static function () use ($app) {
            return $app;
        });


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

        $app->bind('redirect', static function ($app) {
            /** @var Router $router */
            $router = $app['router'];
            $routes = $router->getRoutes();

            $redirector = new Redirector(new UrlGenerator($routes, new Request()));
            $redirector->setSession($app['session']);

            return $redirector;
        });

        $app->bind(Translator::class, function () {
            return $this->getMockBuilder(Translator::class)->getMock();
        });

        $app->bind('session', static function () {
            $repo = new Repository(new ArrayStore());
            return new Store('testing', new CacheBasedSessionHandler($repo, 5));
        });

        $app->singleton('router', static function ($app) {
            return new Router($app['events'], $app);
        });

        $app->singleton('config', static function ($app) {
            $config = new ConfigRepository(new FileLoader($app['files'], __DIR__), 'testing');
            $config->set('view.paths', []);

            return $config;
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

        $capsule = new Manager($app);
        $capsule->addConnection([
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $capsule->setFetchMode(PDO::FETCH_CLASS);


        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        $app->bind('db', static function () use ($capsule) {
            return $capsule->getDatabaseManager();
        });

        if (count($this->migrations)) {
            $finder = (new Finder())->in($this->migrations);

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
                    continue;
                }
            }
        }

        foreach ($this->routes as $route) {
            require_once $route;
        }

        $this->client = new Client(static function ($verb, $payload) {
            return Application::onRequest($verb, $payload);
        }, $this->app);
    }

    /**
     * Do any additional bindings
     *
     * @param Application $app The application
     *
     * @return void
     */
    protected function bindings($app)
    {
        //
    }

    /**
     * Call the given URI and return the Response.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  array   $parameters
     * @param  array   $files
     * @param  array   $server
     * @param  string  $content
     * @param  bool	$changeHistory
     * @return \Illuminate\Http\Response
     */
    protected function call($method, $uri, $parameters = [], $files = [], $server = [], $content = null, $changeHistory = true)
    {
        $this->client->request($method, $uri, $parameters, $files, $server, $content, $changeHistory);

        return $this->client->getResponse();
    }
}
