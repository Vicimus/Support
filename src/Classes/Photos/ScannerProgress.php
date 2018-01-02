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

    public function __construct(int $total)
    {
        $this->total = $total;
        if (!$this->total) {
            $this->autoIncrement = true;
        }
    }

    public function incSuccess()
    {
        $this->successes++;
        $this->output();
    }

    public function incError()
    {
        $this->errors++;
        $this->output();
    }

    public function output(): void
    {
        if ($this->autoIncrement) {
            $this->autoIncrement();
        }

        $this->line(
            '%4d Success%s%4d Errors  | %5d Total',
            $this->successes,
            ' ',
            $this->errors,
            $this->total
        );
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }
}
