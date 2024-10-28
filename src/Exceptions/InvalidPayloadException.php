<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use InvalidArgumentException as InvalidArgument;

use function is_object;

class InvalidPayloadException extends InvalidArgument
{
    public function __construct(mixed $got, string $parameter, mixed ...$acceptable)
    {
        if ($parameter) {
            $parameter = sprintf(' for %s parameter', $parameter);
        }

        $type = is_object($got) ? $got::class : gettype($got);
        $message = sprintf(
            'Invalid argument supplied. Received %s but expected %s%s',
            $type,
            implode(', ', $acceptable),
            $parameter
        );

        parent::__construct($message, 500);
    }
}
