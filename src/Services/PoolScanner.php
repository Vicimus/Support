<?php

namespace Vicimus\Support\Services;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
use Vicimus\Support\Traits\ConsoleOutputter;

class PoolScanner
{
    use ConsoleOutputter;

    private $scanned = 0;
    private $downloaded = 0;

    /**
     * @var ClientInterface
     */
    private $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param callable[]|\Iterator $requests
     */
    public function scan($requests, callable $filter, callable $success, callable $rejected = null)
    {
        $pool = new Pool($this->client, $requests, [
            'concurrency' => 20,
            'fulfilled' => function (Response $response, $index) use ($filter, $success) {
                $size = (int) $response->getHeader('Content-Length')[0];
                $this->scanned += $size;

                $display = round($this->scanned / 1024 / 1024, 2) . 'MB';
                $this->downloaded++;

                $this->line(sprintf('Scanning: %s (%s)', $this->downloaded, $display));
                if (!$filter($response, $index)) {
                    return;
                }

                $success($response, $index);
            },
            'rejected' => function (ClientException $reason, $index) use ($rejected) {
                $rejected($reason, $index);
            },
        ]);

        return $pool->promise();
//                $headers = new PhotoHeaders($response->getHeaders());
//                if (!$this->shouldDownload($headers, $index)) {
//                    return;
//                }
//
//                $positives[$this->locals[$index]] = $this->scan[$index];
//                $vehicle = $this->vehicles[$index];
//                $vehicle->update([
//                    'remote_stock_photo' => $this->remote($headers, $index),
//                ]);
    }
}
