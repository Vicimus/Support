<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class ScannerProgress
 */
class ScannerProgress implements ConsoleOutput
{
    use ConsoleOutputter, PersistsOutput;

    /**
     * Auto increment mode
     * @var bool
     */
    protected $autoIncrement = false;

    /**
     * Bytes
     * @var int
     */
    protected $bytes = 0;

    /**
     * Errors
     * @var int
     */
    protected $errors = 0;

    /**
     * Outdated count
     * @var int
     */
    protected $outdated = 0;

    /**
     * Previous
     * @var string
     */
    protected $previous = '';

    /**
     * Successful downloads
     *
     * @var int
     */
    protected $successes = 0;

    /**
     * Total
     * @var int
     */
    protected $total = 0;

    /**
     * Up to date photos
     * @var int
     */
    protected $upToDate = 0;

    /**
     * ScannerProgress constructor
     *
     * @param int $total The total
     */
    public function __construct(int $total)
    {
        $this->total = $total;
        if (!$this->total) {
            $this->autoIncrement = true;
        }
    }

    /**
     * Increment the bytes
     *
     * @param int $amount The amount to increment by
     *
     * @return ScannerProgress
     */
    public function bytes(int $amount): self
    {
        $this->bytes += $amount;
        return $this->output();
    }

    /**
     * Increment errors
     *
     * @return ScannerProgress
     */
    public function incError(): self
    {
        $this->errors++;
        return $this->output();
    }

    /**
     * Increment outdated
     *
     * @return ScannerProgress
     */
    public function incOutdated(): self
    {
        $this->outdated++;
        return $this->output();
    }

    /**
     * Increment success count
     *
     * @return ScannerProgress
     */
    public function incSuccess(): self
    {
        $this->successes++;
        return $this->output();
    }

    /**
     * Increment up to date progress
     *
     * @return ScannerProgress
     */
    public function incUpToDate(): self
    {
        $this->upToDate++;
        return $this->output();
    }

    /**
     * Display the output
     *
     * @return ScannerProgress
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
     *
     * @param string $method The method to persist with
     *
     * @return ScannerProgress
     */
    public function persist(string $method = 'comment'): self
    {
        $this->$method($this->previous);
        return $this;
    }

    /**
     * Auto increment
     *
     * @return void
     */
    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }

    /**
     * Calculate the bytes
     *
     * @return float
     */
    protected function calculateBytes(): float
    {
        return round($this->bytes / 1024 / 1024, 2);
    }
}
