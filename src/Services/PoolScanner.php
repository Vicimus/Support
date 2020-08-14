<?php

namespace Vicimus\Support\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Pool;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Iterator;
use Vicimus\Support\Traits\ConsoleOutputter;

class PoolScanner
{
    use ConsoleOutputter;

    /**
     * Number downloaded
     * @var int
     */
    private $downloaded = 0;

    /**
     * Number scanned
     * @var int
     */
    private $scanned = 0;

    /**
     * Client
     * @var ClientInterface
     */
    private $client;

    /**
     * The total number of scans
     * @var int
     */
    private $total = 0;

    /**
     * PoolScanner constructor.
     *
     * @param ClientInterface $client The client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Scan using head requests
     *
     * @param callable[]|Iterator $requests  The requests
     * @param callable            $filter    Filter callable to filter out success calls
     * @param callable            $success   The success call
     * @param callable|null       $rejected  Rejected callable
     *
     * @return PromiseInterface
     */
    public function scan($requests, callable $filter, callable $success, callable $rejected = null)
    {
        $pool = new Pool($this->client, $requests, [
            'concurrency' => 20,
            'fulfilled' => function (Response $response, $index) use ($filter, $success) {
                $size = (int) $response->getHeader('Content-Length')[0];
                $display = round($this->scanned / 1024 / 1024, 2) . 'MB';
                $this->downloaded++;

                $output = 'Scanning %s (%s)';
                $args = [$this->downloaded, $display];
                if ($this->total) {
                    $percent = round($this->downloaded / $this->total * 100);
                    $output = 'Scanning %s/%s %s%% (%s)';
                    $args = [
                        $this->downloaded,
                        $this->total,
                        $percent,
                        $display,
                    ];
                }

                $this->line(sprintf($output, ...$args));

                if (!$filter($response, $index)) {
                    $this->line(sprintf('Scanning: %s (%s)', $this->downloaded, $display));
                    return;
                }

                $this->scanned += $size;
                $this->line(sprintf('Scanning: %s (%s)', $this->downloaded, $display));
                $success($response, $index);
            },
            'rejected' => function (GuzzleException $reason, $index) use ($rejected) {
                $this->error($reason->getMessage());
                if ($rejected) {
                    $rejected($reason, $index);
                }
            },
        ]);

        return $pool->promise();
    }

    /**
     * Set the total number of downloads
     *
     * @param int $total The total
     *
     * @return $this
     */
    public function total(int $total): self
    {
        $this->total = $total;
        return $this;
    }
}
