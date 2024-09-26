<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\ConsoleOutput;

class StandardOutput implements ConsoleOutput
{
    public const COLOR_GREEN = "\033[32m";
    public const COLOR_NONE = "\033[0m";
    public const COLOR_YELLOW = "\033[33m";

    protected int $lineLength;

    public function __construct(int $lineLength = 80)
    {
        $this->lineLength = $lineLength;
    }

    public function comment(string $output): void
    {
        $this->line('');
        echo "\033[1;34m" . $output . "\033[0m" . PHP_EOL;
    }

    public function error(string $output): void
    {
        $this->line('');
        $exploded = explode("\n", $output);
        $exploded = array_map(fn (string $value): string => str_pad($value, $this->lineLength), $exploded);

        $exploded = implode("\n", $exploded);
        echo "\033[41m" . $this->pad($exploded) . "\033[0m" . PHP_EOL . PHP_EOL;
    }

    public function info(string $output): void
    {
        $this->line('');
        echo "\033[32m" . $this->pad($output) . "\033[0m" . PHP_EOL;
    }

    public function line(string $output): void
    {
        echo str_pad("\r" . $output, $this->lineLength);
        if ($output) {
            return;
        }

        echo "\r";
    }

    public function linePermanent(string $output): void
    {
        $this->line('');
        echo $this->pad($output) . PHP_EOL;
    }

    protected function pad(string $line): string
    {
        return str_pad($line, $this->lineLength);
    }
}
