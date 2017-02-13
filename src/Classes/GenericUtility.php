<?php

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\Utility;

/**
 * Represents a generic utility
 *
 * @author Jordan
 */
class GenericUtility implements Utility
{
    protected $name;
    protected $desc;
    protected $call;

    /**
     * Construct a generic utility
     *
     * @param string   $name The name of the utility
     * @param string   $desc Description of the utility
     * @param callable $call The method that is called to run the utility
     */
    public function __construct($name, $desc, callable $call)
    {
        $this->name = $name;
        $this->desc = $desc;
        $this->call = $call;
    }

    /**
     * The name of the utility
     *
     * @return string
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * A description of what this utility does
     *
     * @return string
     */
    public function description()
    {
        return $this->desc;
    }

    /**
     * Called to execute the utility
     *
     * @param string[] $flags Optional flags to add to the call.
     *
     * @return void
     */
    public function call(array $flags = null)
    {
        $method = $this->call;
        return $this->results($method());
    }

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     * @return void
     */
    public function results($payload = null)
    {
        return $payload;
    }

    /**
     * Returns a confirmation prompt for the utility.
     *
     * @return string
     */
    public function prompt()
    {
        return null;
    }
}
