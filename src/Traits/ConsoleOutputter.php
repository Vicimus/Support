<?php

declare(strict_types=1);

namespace Vicimus\Support\Traits;

use ErrorException;
use RuntimeException;
use ValueError;
use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Adds the ability to output to a ConsoleOutput interface easily
 */
trait ConsoleOutputter
{
    /**
     * Callable on-bind event
     * @var callable
     */
    protected $onBind;

    /**
     * This stores the ConsoleOutput interface implementation to which the
     * output will be referred. If one is not set, the output is just ignored.
     */
    protected ?ConsoleOutput $output = null;

    /**
     * Bind a ConsoleOutput interface implementation to this class. This
     * enables the output.
     *
     * @param ConsoleOutput | null $output An object implementing ConsoleOutput
     *
     * @return $this
     */
    public function bind(?ConsoleOutput $output): self
    {
        $this->output = $output;
        if ($this->onBind) {
            $method = $this->onBind;
            $method($output);
        }

        return $this;
    }

    public function comment(string $output, mixed ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->comment($this->cleanOutput($output, $args));
    }

    public function error(string $output, mixed ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->error($this->cleanOutput($output, $args));
    }

    public function info(string $output, mixed ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->info($this->cleanOutput($output, $args));
    }

    public function line(string $output, mixed ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->line($this->cleanOutput($output, $args));
    }

    public function linePermanent(string $output, mixed ...$args): void
    {
        if (!$this->output) {
            return;
        }

        $this->output->linePermanent($this->cleanOutput($output, $args));
    }

    public function onBind(callable $action): self
    {
        $this->onBind = $action;
        return $this;
    }

    /**
     * Format the output with its arguments, falling back to the raw text
     *
     * Most callers pass text that is already formatted (or an exception
     * message, URL or product name) with no arguments. That text is printed
     * as-is: running it through vsprintf would treat any "%" as a format
     * directive, and on PHP 8 a directive without a matching argument throws
     * ValueError, which used to kill whole inventory runs.
     *
     * @param string  $output The output string
     * @param mixed[] $args   The replacement arguments
     */
    private function cleanOutput(string $output, array $args): string
    {
        if ($args === []) {
            return $output;
        }

        try {
            return vsprintf($output, $args);
        } catch (ValueError | RuntimeException | ErrorException $ex) {
            return $output;
        }
    }
}
