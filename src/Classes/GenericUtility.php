<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Interfaces\Utility;

/**
 * Represents a generic utility
 *
 * @author Jordan
 */
class GenericUtility implements Utility
{
    /**
     * The name of the utility
     *
     * @var string
     */
    protected $name;

    /**
     * The description for the utility
     *
     * @var string
     */
    protected $desc;

    /**
     * Holds the callable
     *
     * @var callable
     */
    protected $call;

    /**
     * Construct a generic utility
     *
     * @param string   $name The name of the utility
     * @param string   $desc Description of the utility
     * @param callable $call The method that is called to run the utility
     */
    public function __construct(string $name, string $desc, callable $call)
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
    public function name(): string
    {
        return $this->name;
    }

    /**
     * A description of what this utility does
     *
     * @return string
     */
    public function description(): string
    {
        return $this->desc;
    }

    /**
     * Called to execute the utility
     *
     * @return mixed
     */
    public function call()
    {
        $method = $this->call;
        return $this->results($method());
    }

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param mixed $payload OPTIONAL Anything needed to construct the results
     *
     * @return mixed
     */
    public function results($payload = null)
    {
        return $payload;
    }
}
