<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class DownloadProgress implements ConsoleOutput
{
    use ConsoleOutputter;
    use PersistsOutput;

    protected bool $autoIncrement = false;

    protected int $bytes = 0;

    protected int $errors = 0;

    protected string $previous = '';

    protected int $successes = 0;

    public function __construct(protected int $total)
    {
        if ($this->total) {
            return;
        }

        $this->autoIncrement = true;
    }

    public function bytes(int $amount): self
    {
        $this->bytes += $amount;
        return $this->output();
    }

    public function incError(): self
    {
        $this->errors++;
        return $this->output();
    }

    public function incSuccess(): self
    {
        $this->successes++;
        return $this->output();
    }

    public function output(): self
    {
        if ($this->autoIncrement) {
            $this->autoIncrement();
        }

        $output = sprintf(
            '%4d Success%s%4d Errors  | %5d Total | %s MB',
            $this->successes,
            ' ',
            $this->errors,
            $this->total,
            number_format($this->calculateBytes(), 2)
        );

        $this->previous = $output;
        $this->line($output);
        return $this;
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }

    protected function calculateBytes(): float
    {
        return round($this->bytes / 1024 / 1024, 2);
    }
}
