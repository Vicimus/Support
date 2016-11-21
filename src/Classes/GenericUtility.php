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
     * @return void
     */
    public function call()
    {
        $method = $this->call;
        return $method();
    }
}