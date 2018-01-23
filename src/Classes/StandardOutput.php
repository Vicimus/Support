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
    protected $lineLength;

    /**
     * StandardOutput constructor
     *
     * @param int $lineLength Keep lines this length
     */
    public function __construct(int $lineLength = 80)
    {
        $this->lineLength = $lineLength;
    }

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
            return str_pad($value, $this->lineLength);
        }, $output);

        $output = implode("\n", $output);
        echo "\033[41m".$this->pad($output)."\033[0m".PHP_EOL.PHP_EOL;
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
        echo "\033[32m".$this->pad($output)."\033[0m".PHP_EOL;
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
        echo str_pad("\r".$output, $this->lineLength);
        if (!$output) {
            echo "\r";
        }
    }

    /**
     * Make a line a specific length
     *
     * @param string $line The line
     *
     * @return string
     */
    protected function pad(string $line): string
    {
        return str_pad($line, $this->lineLength);
    }
}
