<?php

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Standard output with basic color coding
 */
class StandardOutput implements ConsoleOutput
{
    /**
     * Output information (green text)
     *
     * @param string $output The info to output
     *
     * @return void
     */
    public function info($output)
    {
        echo "\033[32m".$output."\033[0m".PHP_EOL;
    }

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error($output)
    {
        echo "\033[31m".$output."\033[0m".PHP_EOL;
    }

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment($output)
    {
        echo "\033[1;34m".$output."\033[0m".PHP_EOL;
    }

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line($output)
    {
        echo str_pad("\r".$output, 80);
        if (!$output) {
            echo "\r";   
        }
    }
}
