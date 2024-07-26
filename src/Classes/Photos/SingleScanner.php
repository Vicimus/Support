<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Exceptions\PhotoException;
use Vicimus\Support\Exceptions\UnauthorizedPhotoException;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;
use Vicimus\Support\Traits\ConsoleOutputter;

class SingleScanner implements Scanner
{
    use ConsoleOutputter;

    public function __construct(
        protected readonly Vehicle $stock,
        protected readonly Photo $photo
    ) {
        //
    }

    /**
     * Scan the photo for its status
     * @throws PhotoException
     * @throws UnauthorizedPhotoException
     * @throws GuzzleException
     */
    public function scan(Client $client): mixed
    {
        $headers = $this->headers($client, $this->stock, $this->photo);
        return $this->photo->status($headers, $this->stock);
    }

    /**
     * Get the headers for a given URL
     *
     * @throws PhotoException
     * @throws UnauthorizedPhotoException
     * @throws GuzzleException
     */
    protected function headers(Client $client, Vehicle $stock, Photo $photo): Headers
    {
        try {
            $response = $client->request('HEAD', $photo->origin());
        } catch (ClientException $ex) {
            $response = $ex->getResponse()->getStatusCode();
            if ($response === 401) {
                throw new UnauthorizedPhotoException($stock, $photo->origin(), '401 Unauthorized');
            }

            throw new PhotoException($stock, $photo->origin(), $ex->getMessage(), $response);
        } catch (ConnectException $ex) {
            $message = $this->parseCurlError($ex);
            throw new PhotoException($stock, $photo->origin(), $message);
        }

        return new Headers($response);
    }

    /**
     * Parse out the real message from curl
     */
    protected function parseCurlError(ConnectException $ex): string
    {
        $startNeedle = 'cURL error';
        $subNeedle = ': ';
        $stopNeedle = '(see';

        $message = $ex->getMessage();
        $start = stripos($message, $startNeedle);
        if ($start === false) {
            return $message;
        }

        $end = stripos($message, $stopNeedle, $start);

        if ($end === false) {
            return $message;
        }

        $start = stripos($message, $subNeedle, $start) + strlen($subNeedle);
        $message = substr($message, $start, $end - $start);
        return trim($message);
    }
}
