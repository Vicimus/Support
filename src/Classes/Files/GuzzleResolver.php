<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Files;

use ErrorException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;
use Vicimus\Support\Interfaces\FileResolver;

class GuzzleResolver implements FileResolver
{
    private string $path;

    public function __construct(
        private Client $client,
        ?string $path = null
    ) {
        $this->path = $path ?? sys_get_temp_dir();
    }

    /**
     * Open a file and get the handle
     * @return resource | false
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
