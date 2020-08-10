<?php

namespace Vicimus\Support\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
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

    private $scanned = 0;
    private $downloaded = 0;
    /**
     * @var ClientInterface
     */
    private $client;
    private $config;

    public function __construct(ClientInterface $client, array $config = ['concurrency' => 10])
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @param callable[]|Iterator $requests
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
            'rejected' => function (ClientException $reason, $index) use ($rejected) {
                $this->error($reason->getMessage() . PHP_EOL);
                if ($rejected) {
                    $rejected($reason, $index);
                }
            },
        ]);

        return $pool->promise();
    }
}
