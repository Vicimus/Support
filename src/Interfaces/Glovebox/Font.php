<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

use JsonSerializable;

/**
 * Represents a font selection with the glovebox application
 *
 * @property string[][] $fonts
 * @property string $name
 */
interface Font extends JsonSerializable
{
    /**
     * Get the string to use as the src in the font face declaration
     *
     * @param string[] $file
     */
    public function src(array $file): string;

    /**
     * Get the url to the font file
     *
     * @param string[][]|array $file The file information
     */
    public function url(array $file): string;
}
