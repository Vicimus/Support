<?php declare(strict_types = 1);

namespace Vicimus\Support\Providers;

use Vicimus\Support\Classes\Provider;

/**
 * Declares information about this package
 */
class VicimusProvider extends Provider
{
    /**
     * Define which service providers this package offers
     *
     * @return string[]
     */
    public function providers(): array
    {
        return [
            RequestServiceProvider::class,
            QueueReporterProvider::class,
            ViewServiceProvider::class,
        ];
    }
}
