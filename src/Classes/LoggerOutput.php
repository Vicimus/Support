<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Standard output with basic color coding
 */
class LoggerOutput implements ConsoleOutput
{
    /**
     * The path to the file
     *
     * @var string
     */
    protected $path;

    /**
     * LoggerOutput constructor.
     *
     * @param string $path The path to the log file
     */
    public function __construct(string $path)
    {
        $this->path = $path;
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
        $this->write('comment', $output);
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
        $this->write('error', $output);
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
        $this->write('info', $output);
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
        $this->write('line', $output);
    }

    /**
     * Append to the log file
     *
     * @param string $type    The type of message
     * @param string $message The message
     *
     * @return void
     */
    protected function write(string $type, string $message): void
    {
        file_put_contents(
            $this->path,
            sprintf('%s: %s' . PHP_EOL, strtoupper($type), $message),
            FILE_APPEND
        );
    }
}
