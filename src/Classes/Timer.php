<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use RuntimeException;

use function call_user_func;

/**
 * Enforces a minimum amount of time between executions of a method
 */
class Timer
{
    /**
     * The closure to execute
     * @var callable
     */
    private $closure;

    /**
     * An invoker string that can be used to invoke
     */
    private string $invoker;

    /**
     * The time of the last call
     */
    private int $lastCall;

    /**
     * The seconds between calls
     */
    private float $seconds;

    public function __construct(string $invoker, callable $closure, float $seconds)
    {
        $this->invoker = $invoker;
        $this->closure = $closure;
        $this->seconds = $seconds;
        $this->lastCall = (int) round(microtime(true));
    }

    /**
     * Handle the magic call to the invoker label
     * @throws RuntimeException
     */
    public function __call(string $call, mixed $args): void
    {
        if ($call !== $this->invoker) {
            throw new RuntimeException(sprintf('Call to undefined method %s', $call));
        }

        $this->invoke();
    }

    /**
     * Invoke the method. Will only execute if the correct number of seconds
     * have elapsed
     */
    public function invoke(): void
    {
        $now = (int) round(microtime(true));
        if ($now <= $this->lastCall + $this->seconds) {
            return;
        }

        call_user_func($this->closure);
        $this->lastCall = $now;
    }
}
