<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Iterator;

class IterableArray implements Iterator
{
    /**
     * The array we will iterate over
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     * @var mixed[]
     */
    private array $source;

    /**
     * IterableArray constructor
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param mixed[] $source The source array
     */
    public function __construct(array $source)
    {
        $this->source = $source;
    }

    /**
     * Current point
     */
    public function current(): mixed
    {
        return current($this->source);
    }

    /**
     * Key to the iterator
     */
    public function key(): mixed
    {
        return key($this->source);
    }

    /**
     * Get the next iterator point
     */
    public function next(): void
    {
        next($this->source);
    }

    /**
     * Rewind the iterator
     */
    public function rewind(): void
    {
        reset($this->source);
    }

    /**
     * Check if the iterator is still valid
     */
    public function valid(): bool
    {
        return key($this->source) !== null;
    }
}
