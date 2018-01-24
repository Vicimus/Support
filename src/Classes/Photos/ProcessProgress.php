<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class ProcessProgress implements ConsoleOutput
{
    use ConsoleOutputter, PersistsOutput;

    protected $created = 0;
    protected $updated = 0;
    protected $total = 0;
    protected $skipped = 0;
    protected $errors = 0;

    protected $previous = '';

    protected $autoIncrement = false;
    public function __construct(int $total)
    {
        $this->total = $total;
        if (!$this->total) {
            $this->autoIncrement = true;
        }
    }

    public function created(): self
    {
        $this->created++;
        return $this->output();
    }

    public function updated(): self
    {
        $this->updated++;
        return $this->output();
    }

    public function skipped(): self
    {
        $this->skipped++;
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

        $this->previous = $output;
        $this->line($output);
        return $this;
    }

    public function persist($method = 'comment'): self
    {
        $this->$method($this->previous);
        return $this;
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->created + $this->updated + $this->errors + $this->skipped;
    }
}
