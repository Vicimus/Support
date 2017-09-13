<?php declare(strict_types = 1);

namespace Vicimus\Support\Traits;

use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Adds the ability to output to a ConsoleOutput interface easily
 *
 * @author Jordan
 */
trait ConsoleOutputter
{
    /**
     * This stores the ConsoleOutput interface implementation to which the
     * output will be referred. If one is not set, the output is just ignored.
     *
     * @var ConsoleOutput
     */
    protected $output = null;

    /**
     * Output information (green text)
     *
     * @param string $output The info to output
     *
     * @return void
     */
    public function info(string $output): void
    {
        if ($this->output) {
            $this->output->info($output);
        }
    }

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error(string $output): void
    {
        if ($this->output) {
            $this->output->error($output);
        }
    }

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment(string $output): void
    {
        if ($this->output) {
            $this->output->comment($output);
        }
    }

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line(string $output): void
    {
        if ($this->output) {
            $this->output->line($output);
        }
    }

    /**
     * Bind a ConsoleOutput interface implementation to this class. This
     * enables the output.
     *
     * @param ConsoleOutput $output An object implementing ConsoleOutput
     *
     * @return $this
     */
    public function bind(ConsoleOutput $output)
    {
        $this->output = $output;
        return $this;
    }
}
