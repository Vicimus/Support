<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class ScannerProgress implements ConsoleOutput
{
    use ConsoleOutputter;

    protected $successes = 0;
    protected $total = 0;
    protected $errors = 0;

    protected $autoIncrement = false;
    protected $previous = '';

    public function __construct(int $total)
    {
        $this->total = $total;
        if (!$this->total) {
            $this->autoIncrement = true;
        }
    }

    public function incSuccess(): self
    {
        $this->successes++;
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
            '%4d Success%s%4d Errors  | %5d Total',
            $this->successes,
            ' ',
            $this->errors,
            $this->total
        );

        $this->previous = $output;
        return $this;
    }

    public function persist($method = 'comment'): void
    {
        $this->$method($this->previous);
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }
}
