<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

class ProcessProgress implements ConsoleOutput
{
    use ConsoleOutputter;
    use PersistsOutput;

    protected bool $autoIncrement = false;

    protected int $created = 0;

    protected int $errors = 0;

    protected string $previous = '';

    protected int $skipped = 0;

    protected int $total = 0;

    protected int $updated = 0;

    public function __construct(int $total)
    {
        $this->total = $total;
        if ($this->total) {
            return;
        }

        $this->autoIncrement = true;
    }

    public function created(): self
    {
        $this->created++;
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

    /**
     * Persist output to the screen using a specific method
     */
    public function persist(string $method = 'comment'): self
    {
        $this->$method($this->previous);
        return $this;
    }

    public function skipped(): self
    {
        $this->skipped++;
        return $this->output();
    }

    public function updated(): self
    {
        $this->updated++;
        return $this->output();
    }

    protected function autoIncrement(): void
    {
        $this->total = $this->created + $this->updated + $this->errors + $this->skipped;
    }
}
