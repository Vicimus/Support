<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use Iterator;

/**
 * Simple implementation of Iterator for basic arrays
 */
class IterableArray implements Iterator
{
    /**
     * The array we will iterate over
     *
     * @var mixed[]
     */
    private $source;

    /**
     * IterableArray constructor
     *
     * @param mixed[] $source The source array
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * Current point
     *
     * @return mixed
     */
    public function current(): mixed
    {
        return current($this->source);
    }

    /**
     * Key to the iterator
     *
     * @return mixed
     */
    public function key(): mixed
    {
        return key($this->source);
    }

    /**
     * Get the next iterator point
     *
     * @return mixed
     */
    public function next(): void
    {
        next($this->source);
    }

    /**
     * Rewind the iterator
     *
     * @return mixed
     */
    public function rewind(): void
    {
        reset($this->source);
    }

    /**
     * Check if the iterator is still valid
     *
     * @return bool
     */
    public function valid(): bool
    {
        return key($this->source) !== null;
    }
}
