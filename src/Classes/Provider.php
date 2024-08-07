<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

/**
 * Defines various aspects about the providers offered by the Vicimus packages
 * installed
 */
abstract class Provider
{
    /**
     * Define which commands this package offers
     * @return string[]
     */
    public function commands(): array
    {
        return [];
    }

    /**
     * Define which disks this package offers
     * @return string[]
     */
    public function disks(): array
    {
        return [];
    }

    /**
     * Define any prefixes that are necessary to be added to all routes based
     * on the unique nature of your package
     *
     * @return string[]
     */
    public function prefixes(): array
    {
        return [];
    }

    /**
     * Define which service providers this package offers
     *
     * @return string[]
     */
    abstract public function providers(): array;

    public function ui(): ?UserInterface
    {
        return null;
    }

    final protected function public(): string
    {
        return __DIR__ . '/../../../../public';
    }

    final protected function storage(): string
    {
        return __DIR__ . '/../../../../storage/app/public';
    }
}
