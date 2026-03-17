<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class ScannerProgress implements ConsoleOutput
{
    use ConsoleOutputter;
    use PersistsOutput;

    protected bool $autoIncrement = false;

    protected int $bytes = 0;

    protected int $errors = 0;

    protected int $outdated = 0;

    protected string $previous = '';

    protected int $successes = 0;

    protected int $upToDate = 0;

    public function __construct(
        protected int $total,
    ) {
        if ($this->total) {
            return;
        }

        $this->autoIncrement = true;
    }

    /**
     * Increment the bytes
     */
    public function bytes(int $amount): self
    {
        $this->bytes += $amount;
        return $this->output();
    }

    /**
     * Increment errors
     */
    public function incError(): self
    {
        $this->errors++;
        return $this->output();
    }

    /**
     * Increment outdated
     */
    public function incOutdated(): self
    {
        $this->outdated++;
        return $this->output();
    }

    /**
     * Increment success count
     */
    public function incSuccess(): self
    {
        $this->successes++;
        return $this->output();
    }

    /**
     * Increment up-to-date progress
     */
    public function incUpToDate(): self
    {
        $this->upToDate++;
        return $this->output();
    }

    /**
     * Display the output
     */
    public function output(): self
    {
        if ($this->autoIncrement) {
            $this->autoIncrement();
        }

        $output = sprintf(
            '%4d Outdated%s%4d Up To Date%s%4d Errors  | %5d Total | %s MB',
            $this->outdated,
            ' ',
            $this->upToDate,
            ' ',
            $this->errors,
            $this->total,
            number_format($this->calculateBytes(), 2)
        );

        $this->previous = $output;
        $this->line($output);
        return $this;
    }

    /**
     * Output text that will persist on the screen
     */
    public function persist(string $method = 'comment'): self
    {
        $this->$method($this->previous);
        return $this;
    }

    /**
     * Auto increment
     */
    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }

    /**
     * Calculate the bytes
     */
    protected function calculateBytes(): float
    {
        return round($this->bytes / 1024 / 1024, 2);
    }
}
