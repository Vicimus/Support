<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use InvalidArgumentException as InvalidArgument;

class InvalidArgumentException extends InvalidArgument
{
    public function __construct(
        mixed $got,
        string ...$acceptable,
    ) {
        $type = is_object($got) ? $got::class : gettype($got);
        $message = sprintf(
            'Invalid argument supplied. Received %s but expected %s',
            $type,
            implode(', ', $acceptable)
        );

        parent::__construct($message, 500);
    }
}
