<?php declare(strict_types = 1);

namespace Vicimus\Support\Exceptions;

use Vicimus\Support\Interfaces\Vehicle;

/**
 * Class UnauthorizedPhotoException
 */
class UnauthorizedPhotoException extends PhotoException
{
    /**
     * PhotoException constructor
     *
     * @param Vehicle     $stock    The stock
     * @param string      $url      The url that failed
     * @param null|string $specific The specific error, if available
     */
    public function __construct(Vehicle $stock, string $url, ?string $specific = null)
    {
        parent::__construct($stock, $url, $specific, 401);
    }
}
