<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class DownloadProgress
 */
class DownloadProgress implements ConsoleOutput
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
     * Previous output
     * @var string
     */
    protected $previous = '';

    /**
     * The number of successes
     * @var int
     */
    protected $successes = 0;

    /**
     * Total
     * @var int
     */
    protected $total = 0;

    /**
     * DownloadProgress constructor
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
     * Add bytes
     *
     * @param int $amount The number of bytes to add
     *
     * @return DownloadProgress
     */
    public function bytes(int $amount): self
    {
        $this->bytes += $amount;
        return $this->output();
    }

    /**
     * Increment error
     *
     * @return DownloadProgress
     */
    public function incError(): self
    {
        $this->errors++;
        return $this->output();
    }

    /**
     * Increment success
     *
     * @return DownloadProgress
     */
    public function incSuccess(): self
    {
        $this->successes++;
        return $this->output();
    }

    /**
     * Output
     *
     * @return DownloadProgress
     */
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

    /**
     * Autoincrement
     *
     * @return void
     */
    protected function autoIncrement(): void
    {
        $this->total = $this->successes + $this->errors;
    }

    /**
     * Calculate bytes
     *
     * @return float
     */
    protected function calculateBytes(): float
    {
        return round($this->bytes / 1024 / 1024, 2);
    }
}
