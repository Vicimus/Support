<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Enforces similar behaviour between processors, generally implemented
 * in inventory, showroom and rates packages.
 */
interface Processor
{
    /**
     * Bind a ConsoleOutput interface implementation to this class. This
     * enables the output.
     *
     * @param ConsoleOutput $output An object implementing ConsoleOutput
     *
     * @return $this
     */
    public function bind(ConsoleOutput $output);

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     */
    public function comment(string $output): void;

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     */
    public function error(string $output): void;

    /**
     * Output info
     *
     * @param string $output The info to output
     *
     */
    public function info(string $output): void;

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     */
    public function line(string $output): void;

    /**
     * Get an option
     *
     * @param string $name The name of the option to get
     *
     */
    public function option(string $name): mixed;

    /**
     * Set the options for this service
     *
     * @param string[] $options The options to set
     *
     * @return $this
     */
    public function options(array $options): Processor;

    /**
     * Return an integer describing the priority of the processor. Higher
     * number means it will be run first, lower number means it will be run
     * after others.
     *
     * The scale should be 1 to 10.
     *
     */
    public function priority(): int;

    /**
     * Init the process
     *
     */
    public function process(): bool;
}
