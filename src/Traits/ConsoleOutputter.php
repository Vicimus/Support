<?php

declare(strict_types=1);

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
     * Check the output for character mismatch
     *
     * @param string   $output The output string
     * @param string[] $args   The replacement arguments
     */
    private function cleanOutput(string $output, array $args): string
    {
        try {
            return vsprintf($output, $args);
        } catch (RuntimeException | ErrorException $ex) {
            return $output;
        }
    }
}
