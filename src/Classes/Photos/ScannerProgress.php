<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class ScannerProgress implements ConsoleOutput
{
    use ConsoleOutputter, PersistsOutput;

    protected $outdated = 0;
    protected $upToDate = 0;
    protected $total = 0;
    protected $errors = 0;
    protected $bytes = 0;
    protected $autoIncrement = false;
    protected $previous = '';

    public function __construct(int $total)
    {
        $this->total = $total;
        if (!$this->total) {
            $this->autoIncrement = true;
        }
    }

    public function bytes(int $amount): self
    {
        $this->bytes += $amount;
        return $this->output();
    }

    public function incOutdated(): self
    {
        $this->outdated++;
        return $this->output();
    }

    public function incUpToDate(): self
    {
        $this->upToDate++;
        return $this->output();
    }

    public function incError(): self
    {
        $this->errors++;
        return $this->output();
    }

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

    protected function calculateBytes(): float
    {
        return round($this->bytes / 1024 / 1024, 2);
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }
}
