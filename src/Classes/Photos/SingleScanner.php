<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use Vicimus\Support\Classes\API\Headers;
use Vicimus\Support\Exceptions\PhotoException;
use Vicimus\Support\Exceptions\UnauthorizedPhotoException;
use Vicimus\Support\Interfaces\Photo;
use Vicimus\Support\Interfaces\Vehicle;
use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Scan a single photo for its status
 */
class SingleScanner implements Scanner
{
    use ConsoleOutputter;

    /**
     * The photo to scan
     *
     * @var Photo
     */
    protected $photo;

    /**
     * The vehicle related to the photo
     *
     * @var Vehicle
     */
    protected $stock;

    /**
     * SingleScanner constructor.
     *
     * @param Vehicle $vehicle The vehicle related to this photo
     * @param Photo   $photo   The photo to scan
     */
    public function __construct(Vehicle $vehicle, Photo $photo)
    {
        $this->stock = $vehicle;
        $this->photo = $photo;
    }

    /**
     * Scan the photo for its status
     *
     * @param Client $client A client to make requests with
     *
     * @return mixed
     *
     * @throws PhotoException
     * @throws UnauthorizedPhotoException
     */
    public function scan(Client $client)
    {
        $headers = $this->headers($client, $this->stock, $this->photo);
        return $this->photo->status($headers, $this->stock);
    }

    /**
     * Get the headers for a given URL
     *
     * @param Client  $client The client to use with scanning
     * @param Vehicle $stock  The stock related to the request
     * @param Photo   $photo  The url to send the HEAD request to
     *
     * @return Headers
     *
     * @throws PhotoException
     * @throws UnauthorizedPhotoException
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     *
     * @param ConnectException $ex The exception that occurred
     *
     * @return string
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
