<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Ensures a set of methods to output in different formats
 *
 * @author Jordan
 */
interface ConsoleOutput
{
    /**
     * Output information (green text)
     *
     * @param string $output The info to output
     *
     * @return void
     */
    public function info(string $output): void;

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error(string $output): void;

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment(string $output): void;

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line(string $output): void;
}
