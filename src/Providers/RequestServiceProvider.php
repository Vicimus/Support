<?php declare(strict_types = 1);

namespace Vicimus\Support\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request as IllRequest;
use Illuminate\Support\ServiceProvider;
use Vicimus\Support\Http\Request;

/**
 * Class RequestServiceProvider
 */
class RequestServiceProvider extends ServiceProvider
{
    /**
     * Register services
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Request::class, static function (Application $app): Request {
            return new Request($app->make(IllRequest::class));
        });
    }
}
