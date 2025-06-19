<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Exception;
use Throwable;
use Vicimus\Support\Interfaces\Utility;

class UtilityException extends Exception
{
    public function __construct(
        Utility $utility,
        Throwable $original,
    ) {
        $message = sprintf(
            'Utility [%s] (%s) threw an exception during execution. The message: %s in file %s on line %s',
            $utility->name(),
            $utility::class,
            $original->getMessage(),
            $original->getFile(),
            $original->getLine()
        );

        parent::__construct($message);
    }
}
