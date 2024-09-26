<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Vicimus\Support\Interfaces\Vehicle;

class UnauthorizedPhotoException extends PhotoException
{
    public function __construct(Vehicle $stock, string $url, ?string $specific = null)
    {
        parent::__construct($stock, $url, $specific, 401);
    }
}
