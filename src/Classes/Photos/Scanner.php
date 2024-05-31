<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Client;
use Vicimus\Support\Exceptions\PhotoException;
use Vicimus\Support\Exceptions\UnauthorizedPhotoException;
use Vicimus\Support\Interfaces\ConsoleOutput;

/**
 * Interface Scanner
 */
interface Scanner extends ConsoleOutput
{
    /**
     * Scan a photo or photos for status
     *
     * @param Client $client A client to use for scanning
     *
     * @return PhotoStatus|PhotoStatus[]
     *
     * @throws PhotoException
     * @throws UnauthorizedPhotoException
     */
    public function scan(Client $client): PhotoStatus|array;
}
