<?php

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
    public function info($output);

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error($output);

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment($output);

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line($output);
}
