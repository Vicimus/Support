<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Enforces similar behaviour between processors, generally implemented
 * in inventory, showroom and rates packages.
 */
interface Processor extends ConsoleOutput
{
    /**
     * Bind a ConsoleOutput interface implementation to this class. This
     * enables the output.
     */
    public function bind(ConsoleOutput $output): self;

    /**
     * Output a comment (yellow text)
     */
    public function comment(string $output): void;

    /**
     * Output an error (red text)
     */
    public function error(string $output): void;

    /**
     * Output info
     */
    public function info(string $output): void;

    /**
     * Output text (grey text)
     */
    public function line(string $output): void;

    /**
     * Get an option
     */
    public function option(string $name): mixed;

    /**
     * Set the options for this service
     *
     * @param string[]|string[][] $options
     */
    public function options(array $options): Processor;

    /**
     * Return an integer describing the priority of the processor. Higher
     * number means it will be run first, lower number means it will be run
     * after others.
     *
     * The scale should be 1 to 10.
     */
    public function priority(): int;

    /**
     * Init the process
     */
    public function process(): bool;
}
