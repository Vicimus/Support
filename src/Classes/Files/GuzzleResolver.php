<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Files;

use ErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Vicimus\Support\Interfaces\FileResolver;

/**
 * Class GuzzleResolver
 */
class GuzzleResolver implements FileResolver
{
    /**
     * The guzzle client
     *
     * @var Client
     */
    private $client;

    /**
     * Path to store stuff
     *
     * @var string
     */
    private $path;

    /**
     * GuzzleResolver constructor.
     *
     * @param Client      $client The guzzle client
     * @param string|null $path   The path to store files
     */
    public function __construct(Client $client, ?string $path = null)
    {
        $this->client = $client;
        $this->path = $path ?? sys_get_temp_dir();
    }

    /**
     * Open a file and get the handle
     *
     * @param string $path The path to open
     * @param string $mode The mode to use
     *
     * @return resource
     *
     * @throws ErrorException
     */
    public function open(string $path, string $mode)
    {
        if (file_exists($path)) {
            return fopen($path, $mode);
        }

        try {
            $response = $this->client->request('GET', $path);
        } catch (GuzzleException $ex) {
            throw new ErrorException($ex->getMessage());
        }

        $content = (string) $response->getBody();
        $local = Str::random(32);
        $fullPath = sprintf('%s/%s', $this->path, $local);
        file_put_contents($fullPath, $content);

        return fopen($fullPath, $mode);
    }
}
