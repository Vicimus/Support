<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\API;

use Generator;

/**
 * Class AsyncRequest Pool
 */
class AsyncRequestPool
{
    /**
     * The number of completed requests
     *
     * @var int
     */
    protected $counter = 0;

    /**
     * Requests to make
     *
     * @var AsyncRequest[]
     */
    protected $requests = [];

    /**
     * The verb this pool will be using
     *
     * @var string
     */
    protected $verb;

    /**
     * AsyncRequestPool constructor
     *
     * @param string $verb HEAD, GET, POST, etc
     */
    public function __construct(string $verb = 'GET')
    {
        $this->verb = $verb;
    }

    /**
     * Add an async request
     *
     * @param AsyncRequest $request The request to add
     *
     * @return void
     */
    public function add(AsyncRequest $request): void
    {
        $request->verb($this->verb);
        $this->requests[] = $request;
    }

    /**
     * Get request at
     *
     * @param int $index The index to get
     *
     * @return AsyncRequest
     */
    public function at(int $index): AsyncRequest
    {
        return $this->requests[$index];
    }

    /**
     * Counter
     *
     * @return int
     */
    public function counter(): int
    {
        return ++$this->counter;
    }

    /**
     * Get requests
     *
     * @return Generator
     */
    public function requests(): Generator
    {
        foreach ($this->requests as $index => $request) {
            yield $index => $request->getRequest();
        }
    }

    /**
     * The total number of requests
     *
     * @return int
     */
    public function total(): int
    {
        return count($this->requests);
    }
}
