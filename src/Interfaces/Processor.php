<?php

namespace Vicimus\Support\Interfaces;

/**
 * Enforces similar behaviour between processors, generally implemented
 * in inventory, showroom and rates packages.
 */
interface Processor
{
    public function info($output);

    /**
     * Output an error (red text)
     *
     * @param string $output The error to output
     *
     * @return void
     */
    public function error($output);

    /**
     * Output a comment (yellow text)
     *
     * @param string $output The comment to output
     *
     * @return void
     */
    public function comment($output);

    /**
     * Output text (grey text)
     *
     * @param string $output The text to output
     *
     * @return void
     */
    public function line($output);

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
     * Init the process
     *
     * @return void
     */
    public function process();

    /**
     * Set the options for this service
     *
     * @param array $options The options to set
     *
     * @return $this
     */
    public function options(array $options);

    /**
     * Get an option
     *
     * @param string $name The name of the option to get
     *
     * @return mixed
     */
    public function option($name);

    /**
     * Return an integer describing the priority of the processor. Higher
     * number means it will be run first, lower number means it will be run
     * after others.
     *
     * The scale should be 1 to 10.
     */
    public function priority() : int;
}