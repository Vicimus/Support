<?php declare(strict_types = 1);

namespace Vicimus\Support\Traits;

use ErrorException;
use RuntimeException;
use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Adds the ability to output to a ConsoleOutput interface easily
 */
trait ConsoleOutputter
{
    /**
     * Callable on-bind event
     *
     * @var callable
     */
    protected $onBind;

    /**
     * This stores the ConsoleOutput interface implementation to which the
     * output will be referred. If one is not set, the output is just ignored.
     *
     * @var ConsoleOutput
     */
    protected $output = null;

    /**
     * Bind a ConsoleOutput interface implementation to this class. This
     * enables the output.
     *
     * @param ConsoleOutput $output An object implementing ConsoleOutput
     *
     * @return $this
     */
    public function bind(?ConsoleOutput $output)
    {
        $this->output = $output;
        if ($this->onBind) {
            $method = $this->onBind;
            $method($output);
        }

        return $this;
    }

    /**
     * Output a comment (yellow text)
     *
     * @param string $output  The comment to output
     * @param mixed  ...$args Additional arguments for output
     *
     * @return void
     */
    public function comment(string $output, ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->comment($this->cleanOutput($output, $args));
    }

    /**
     * Output an error (red text)
     *
     * @param string $output  The error to output
     * @param mixed  ...$args Additional arguments for vsprint
     *
     * @return void
     */
    public function error(string $output, ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->error($this->cleanOutput($output, $args));
    }

    /**
     * Output information (green text)
     *
     * @param string $output  The info to output
     * @param mixed  ...$args Additional arguments for vsprint
     *
     * @return void
     */
    public function info(string $output, ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->info($this->cleanOutput($output, $args));
    }

    /**
     * Output text (grey text)
     *
     * @param string $output  The text to output
     * @param mixed  ...$args Additional arguments for output
     *
     * @return void
     */
    public function line(string $output, ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->line($this->cleanOutput($output, $args));
    }

    /**
     * Output text (grey text) that persists
     *
     * @param string $output  The output to send
     * @param mixed  ...$args The args
     *
     * @return void
     */
    public function linePermanent(string $output, ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->linePermanent($this->cleanOutput($output, $args));
    }

    /**
     * Set a method to be called on bind
     *
     * @param callable $action The action to take
     *
     * @return $this
     */
    public function onBind(callable $action): self
    {
        $this->onBind = $action;
        return $this;
    }

    /**
     * Check the output for character mismatch
     *
     * @param string   $output The output string
     * @param string[] $args   The replacement arguments
     *
     * @return string
     */
    private function cleanOutput(string $output, array $args): string
    {
        if (!count($args)) {
            return $output;
        }

        try {
            return vsprintf($output, $args);
        } catch (RuntimeException | ErrorException $ex) {
            return $output;
        }
    }
}
