<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use RuntimeException;

use function call_user_func;

/**
 * Class Timer
 *
 * Enforces a minimum amount of time between executions of a method
 */
class Timer
{
    /**
     * The closure to execute
     *
     * @var callable
     */
    private $closure;

    /**
     * An invoker string that can be used to invoke
     *
     * @var string
     */
    private $invoker;

    /**
     * The time of the last call
     *
     * @var int
     */
    private $lastCall;

    /**
     * The seconds between calls
     *
     * @var int
     */
    private $seconds;

    /**
     * Timer constructor.
     *
     * @param string   $invoker The invoker label
     * @param callable $closure The closure to execute
     * @param int      $seconds The seconds delay
     */
    public function __construct(string $invoker, callable $closure, int $seconds)
    {
        $this->invoker = $invoker;
        $this->closure = $closure;
        $this->seconds = $seconds;
        $this->lastCall = (int) round(microtime(true));
    }

    /**
     * Handle the magic call to the invoker label
     *
     * @param string $call The call name
     * @param mixed  $args Arguments
     *
     * @return void
     *
     * @throws RuntimeException
     */
    public function __call(string $call, $args): void
    {
        if ($call !== $this->invoker) {
            throw new RuntimeException(sprintf('Call to undefined method %s', $call));
        }

        $this->invoke();
    }

    /**
     * Invoke the method. Will only execute if the correct number of seconds
     * have elapsed
     *
     * @return void
     */
    public function invoke(): void
    {
        $now = (int) round(microtime(true));
        if ($now > $this->lastCall + $this->seconds) {
            call_user_func($this->closure);
            $this->lastCall = $now;
        }
    }
}
