<?php declare(strict_types = 1);

namespace Vicimus\Support\Providers;

/**
 * Declares information about this package
 */
class VicimusProvider
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
        ];
    }
}
