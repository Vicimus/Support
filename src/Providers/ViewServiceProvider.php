<?php

declare(strict_types=1);

namespace Vicimus\Support\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class ViewServiceProvider
 */
class ViewServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     */
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'support');
    }
}
