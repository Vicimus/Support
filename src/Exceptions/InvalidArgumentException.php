<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use InvalidArgumentException as InvalidArgument;

/**
 * Class InvalidArgumentException
 */
class InvalidArgumentException extends InvalidArgument
{
    /**
     * InvalidArgumentException constructor
     *
     * @param mixed    $got           The argument that was invalid
     * @param string[] ...$acceptable What would have been acceptable
     */
    public function __construct(mixed $got, string ...$acceptable)
    {
        $type = is_object($got) ? $got::class : gettype($got);
        $message = sprintf(
            'Invalid argument supplied. Received %s but expected %s',
            $type,
            implode(', ', $acceptable)
        );

        parent::__construct($message, 500);
    }
}
