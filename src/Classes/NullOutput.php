<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Class NullOutput
 */
class NullOutput implements ConsoleOutput
{
    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment(string $output): void
    {
        //
    }

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error(string $output): void
    {
        //
    }

    /**
     * Output information (green text)
     *
     * @param string $output The info to output
     *
     * @return void
     */
    public function info(string $output): void
    {
        //
    }

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line(string $output): void
    {
        //
    }

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function linePermanent(string $output): void
    {
        //
    }
}
