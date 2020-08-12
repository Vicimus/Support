<?php

namespace Vicimus\Support\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Pool;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Iterator;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class PoolDownloader
 */
class PoolDownloader
{
    use ConsoleOutputter;

    /**
     * @var ClientInterface
     */
    private $client;

    /**
     * The configuration
     * @var array|int[]
     */
    private $config;

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
     * PoolDownloader constructor.
     *
     * @param ClientInterface $client The client
     * @param array|int[]     $config The configuration
     */
    public function __construct(ClientInterface $client, array $config = ['concurrency' => 10])
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * Get the pool downloader
     *
     * @param callable[]|Iterator $requests The download requests
     * @param callable            $success  The success callable
     * @param callable|null       $rejected The rejected callable
     *
     * @return PromiseInterface
     */
    public function pool($requests, callable $success, callable $rejected = null): PromiseInterface
    {
        $pool = new Pool($this->client, $requests, [
            'concurrency' => $this->config['concurrency'],
            'fulfilled' => function (Response $response, $index) use ($success) {
                $size = (int) $response->getHeader('Content-Length')[0];
                $this->scanned += $size;
                $display = round($this->scanned / 1024 / 1024, 2) . 'MB';
                $this->downloaded++;

                $this->line(sprintf('Downloading %s (%s)', $this->downloaded, $display));
                $success($response, $index);
            },
            'rejected' => function (GuzzleException $reason, $index) use ($rejected) {
                $this->error($reason->getMessage() . PHP_EOL);
                if ($rejected) {
                    $rejected($reason, $index);
                }
            },
        ]);

        return $pool->promise();
    }
}
