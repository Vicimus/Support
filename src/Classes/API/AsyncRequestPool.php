<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\API;

use Generator;

class AsyncRequestPool
{
    protected int $counter = 0;

    /**
     * Requests to make
     * @var AsyncRequest[]
     */
    protected array $requests = [];

    public function __construct(
        protected string $verb = 'GET'
    ) {
    }

    public function add(AsyncRequest $request): void
    {
        $request->verb($this->verb);
        $this->requests[] = $request;
    }

    public function at(int $index): AsyncRequest
    {
        return $this->requests[$index];
    }

    public function counter(): int
    {
        return ++$this->counter;
    }

    public function requests(): Generator
    {
        foreach ($this->requests as $index => $request) {
            yield $index => $request->getRequest();
        }
    }

    public function total(): int
    {
        return count($this->requests);
    }
}
