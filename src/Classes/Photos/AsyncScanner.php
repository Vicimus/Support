<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use Illuminate\Support\Collection;
use Throwable;
use Vicimus\Support\Classes\API\AsyncRequestPool;
use Vicimus\Support\Interfaces\ConsoleOutput;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Class AsyncScanner
 *
 * Used to make async head requests
 */
class AsyncScanner implements Scanner
{
    use ConsoleOutputter;

    /**
     * The pool to use with the requests
     *
     * @var AsyncRequestPool
     */
    protected $async;

    /**
     * Client
     *
     * @var Client
     */
    protected $client;

    /**
     * @var ScannerProgress
     */
    protected $progress;

    /**
     * AsyncScanner constructor.
     *
     * @param AsyncRequestPool $async The pool to scan through
     */
    public function __construct(AsyncRequestPool $async)
    {
        $this->async = $async;
    }

    /**
     * Scan the photos for photo status
     *
     * @param Client $client The client to use for requests
     *
     * @return mixed|Collection|PhotoStatus[]
     */
    public function scan(Client $client)
    {
        $this->progress = (new ScannerProgress($this->async->total()))->bind($this->output);

        /* @var Collection|PhotoStatus[] $status */
        $status = new Collection();
        $pool = new Pool($client, $this->async->requests(), [
            'concurrency' => 5,
            'fulfilled' => function ($response, $index) use ($status): void {
                $this->progress->incSuccess();
                $request = $this->async->at($index);
                $payload = $request->process($response);
                if ($payload) {
                    $status->push($payload);
                }
            },
            'rejected' => function (RequestException $reason, $index): void {
                $this->progress->incError();
                $response = $reason->getResponse();
                $status = 500;
                if ($response) {
                    $status = $response->getStatusCode();
                }

                $request = $this->async->at($index);
                /* @var Photo $photo */
                $photo = $request->get('photo');
                $photo->update([
                    'etag' => null,
                    'status' => $status,
                    'bytes' => 0,
                ]);
            },
        ]);

        $pool->promise()->wait();
        $this->progress->persist();
        return $status;
    }
}
