<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\OEM;

/**
 * Interface Make
 */
interface Make
{
    /**
     * Retrieve the name to use for the make
     *
     */
    public function getName(): string;

    /**
     * Get images for the make
     *
     * @return Image[]
     */
    public function images(): array;

    /**
     * Get a logo
     *
     */
    public function logo(): ?string;

    /**
     * Get a style from the Make
     *
     * @param string      $property The style to get
     * @param string|null $default  The default if no match was found
     *
     */
    public function style(string $property, ?string $default = null): ?string;

    /**
     * Return the makes properties as variable data
     *
     * @return string[]
     */
    public function variables(): array;
}
