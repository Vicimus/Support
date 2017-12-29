<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Standard output with basic color coding
 */
class StandardOutput implements ConsoleOutput
{
    /**
     * Line length
     *
     * @var int
     */
    protected const LINE_LENGTH = 80;

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment(string $output): void
    {
        $this->line('');
        echo "\033[1;34m".$output."\033[0m".PHP_EOL;
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
        $this->line('');
        $output = explode("\n", $output);
        $output = array_map(function (string $value): string {
            return str_pad($value, self::LINE_LENGTH);
        }, $output);

        $output = implode("\n", $output);
        echo "\033[41m".$output."\033[0m".PHP_EOL.PHP_EOL;
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
        $this->line('');
        echo "\033[32m".$output."\033[0m".PHP_EOL;
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
        echo str_pad("\r".$output, self::LINE_LENGTH);
        if (!$output) {
            echo "\r";
        }
    }
}
