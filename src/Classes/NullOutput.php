<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

class NullOutput implements ConsoleOutput
{
    /**
     * Output a comment (yellow text)
     */
    public function comment(string $output): void
    {
        //
    }

    /**
     * Output an error (red text)
     */
    public function error(string $output): void
    {
        //
    }

    /**
     * Output information (green text)
     */
    public function info(string $output): void
    {
        //
    }

    /**
     * Output text (grey text)
     */
    public function line(string $output): void
    {
        //
    }

    /**
     * Output text (grey text)
     */
    public function linePermanent(string $output): void
    {
        //
    }
}
