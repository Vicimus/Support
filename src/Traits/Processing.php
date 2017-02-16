<?php

namespace Vicimus\Support\Traits;

/**
 * Adds some common methods to processors
 */
trait Processing
{
    /**
     * Holds the options for the processor
     *
     * @var array
     */
    protected $options = [];

    /**
     * Set the options for this service
     *
     * @param array $options The options to set
     *
     * @return $this
     */
    public function options(array $options)
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * Get an option
     *
     * @param string $name The name of the option to get
     *
     * @return mixed
     */
    public function option($name)
    {
        if (!array_key_exists($name, $this->options)) {
            return null;
        }

        return $this->options[$name];
    }

    /**
     * Return the priortiy of your processor
     *
     * @return int
     */
    public function priority() : int
    {
        return 5;
    }
}