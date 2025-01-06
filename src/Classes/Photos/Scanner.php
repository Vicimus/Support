<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Photos;

use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use Vicimus\Support\Exceptions\PhotoException;
use Vicimus\Support\Exceptions\UnauthorizedPhotoException;
use Vicimus\Support\Interfaces\ConsoleOutput;

interface Scanner extends ConsoleOutput
{
    /**
     * Scan a photo or photos for status
     * @throws PhotoException
     * @throws UnauthorizedPhotoException
     */
    public function scan(Client $client): PhotoStatus | Collection;
}
