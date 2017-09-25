<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Enforces similar behaviour between processors, generally implemented
 * in inventory, showroom and rates packages.
 */
interface Processor
{
    /**
     * Output info
     *
     * @param string $output The info to output
     *
     * @return void
     */
    public function info(string $output): void;

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error(string $output): void;

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment(string $output): void;

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line(string $output): void;

    /**
     * Bind a ConsoleOutput interface implementation to this class. This
     * enables the output.
     *
     * @param ConsoleOutput $output An object implementing ConsoleOutput
     *
     * @return $this
     */
    public function bind(ConsoleOutput $output): Processor;

    /**
     * Init the process
     *
     * @return bool
     */
    public function process(): bool;

    /**
     * Set the options for this service
     *
     * @param string[] $options The options to set
     *
     * @return $this
     */
    public function options(array $options): Processor;

    /**
     * Get an option
     *
     * @param string $name The name of the option to get
     *
     * @return mixed
     */
    public function option(string $name);

    /**
     * Return an integer describing the priority of the processor. Higher
     * number means it will be run first, lower number means it will be run
     * after others.
     *
     * The scale should be 1 to 10.
     *
     * @return int
     */
    public function priority(): int;
}
