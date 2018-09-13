<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Throwable;
use Vicimus\Support\Exceptions\UtilityException;
use Vicimus\Support\Interfaces\Utility;

/**
 * Represents a generic utility
 */
class GenericUtility implements Utility
{
    /**
     * Holds the callable
     *
     * @var callable
     */
    protected $call;

    /**
     * The description for the utility
     *
     * @var string
     */
    protected $desc;

    /**
     * The name of the utility
     *
     * @var string
     */
    protected $name;

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
     * Called to execute the utility
     *
     * @param mixed[] $flags Optional flags to pass along
     *
     * @throws UtilityException
     *
     * @return mixed
     */
    public function call(?array $flags = null)
    {
        $method = $this->call;
        try {
            return $this->results($method($flags));
        } catch (Throwable $ex) {
            throw new UtilityException($this, $ex);
        }
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
     * The name of the utility
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * To be displayed after a call, to show the results of the call
     *
     * @param string|string[] $payload OPTIONAL Anything needed to construct the results
     *
     * @return mixed
     */
    public function results($payload = null)
    {
        return $payload;
    }
}
