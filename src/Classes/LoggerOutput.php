<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

class LoggerOutput implements ConsoleOutput
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function comment(string $output): void
    {
        $this->write('comment', $output);
    }

    public function error(string $output): void
    {
        $this->write('error', $output);
    }

    public function info(string $output): void
    {
        $this->write('info', $output);
    }

    public function line(string $output): void
    {
        $this->write('line', $output);
    }

    public function linePermanent(string $output): void
    {
        $this->write('linePermanent', $output);
    }

    protected function write(string $type, string $message): void
    {
        file_put_contents(
            $this->path,
            sprintf('%s: %s' . PHP_EOL, strtoupper($type), $message),
            FILE_APPEND
        );
    }
}
