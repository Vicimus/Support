<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class ProcessProgress
 */
class ProcessProgress implements ConsoleOutput
{
    use ConsoleOutputter;
    use PersistsOutput;

    /**
     * Auto increment mode
     */
    protected bool $autoIncrement = false;

    /**
     * The number of created
     *
     */
    protected int $created = 0;

    /**
     * The number of errors
     */
    protected int $errors = 0;

    /**
     * The previous
     */
    protected string $previous = '';

    /**
     * Number of skipped
     */
    protected int $skipped = 0;

    /**
     * The total
     */
    protected int $total = 0;

    /**
     * The number updated
     *
     */
    protected int $updated = 0;

    /**
     * ProcessProgress constructor
     *
     * @param int $total Total
     */
    public function __construct(int $total)
    {
        $this->total = $total;
        if ($this->total) {
            return;
        }

        $this->autoIncrement = true;
    }

    /**
     * Increment created
     * @return ProcessProgress
     */
    public function created(): self
    {
        $this->created++;
        return $this->output();
    }

    /**
     * Increment error count
     * @return ProcessProgress
     */
    public function incError(): self
    {
        $this->errors++;
        return $this->output();
    }

    /**
     * Output the progress
     * @return ProcessProgress
     */
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
     * Perist output to the screen using a specific method
     *
     * @param string $method The output method to use (info, comment, etc)
     *
     * @return ProcessProgress
     */
    public function persist(string $method = 'comment'): self
    {
        $this->$method($this->previous);
        return $this;
    }

    /**
     * Increment skipped
     * @return ProcessProgress
     */
    public function skipped(): self
    {
        $this->skipped++;
        return $this->output();
    }

    /**
     * Increment updated
     * @return ProcessProgress
     */
    public function updated(): self
    {
        $this->updated++;
        return $this->output();
    }

    /**
     * Auto increment
     *
     */
    protected function autoIncrement(): void
    {
        $this->total = $this->created + $this->updated + $this->errors + $this->skipped;
    }
}
