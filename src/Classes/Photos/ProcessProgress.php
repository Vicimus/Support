<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class ProcessProgress implements ConsoleOutput
{
    use ConsoleOutputter;

    protected $created = 0;
    protected $updated = 0;
    protected $total = 0;
    protected $skipped = 0;
    protected $errors = 0;

    protected $autoIncrement = false;

    public function __construct(int $total)
    {
        $this->total = $total;
        if (!$this->total) {
            $this->autoIncrement = true;
        }
    }

    public function created()
    {
        $this->created++;
        $this->output();
    }

    public function updated()
    {
        $this->updated++;
        $this->output();
    }

    public function skipped()
    {
        $this->skipped++;
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
            '%4d Created%s%4d Updated%s%4d Skipped%s%4d Errors  | %5d Total',
            $this->created,
            ' ',
            $this->updated,
            ' ',
            $this->skipped,
            ' ',
            $this->errors,
            $this->total
        );
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->created + $this->updated + $this->errors + $this->skipped;
    }
}
