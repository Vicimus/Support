<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Response;
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
     * Track progress and output it to the screen
     *
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
            'fulfilled' => function (Response $response, $index) use ($status): void {

                $bytes = (int) $response->getHeader('Content-Length')[0] ?? 0;


                $request = $this->async->at($index);
                $payload = $request->process($response);
                if ($payload) {
                    $status->push($payload);
                    $this->progress->incOutdated();
                    $this->progress->bytes($bytes);
                } else {
                    $this->progress->incUpToDate();
                }
            },
            'rejected' => function (ClientException $reason, $index): void {
                $this->progress->incError();

                $response = $reason->getResponse();

                $request = $this->async->at($index);
                /* @var Photo $photo */
                $photo = $request->get('photo');
                $photo->update([
                    'etag' => null,
                    'status' => $response->getStatusCode(),
                    'bytes' => 0,
                ]);
            },
        ]);

        $pool->promise()->wait();
        $this->progress->persist();
        return $status;
    }
}
