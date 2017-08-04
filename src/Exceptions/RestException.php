<?php declare(strict_types = 1);

namespace Vicimus\Support\Exceptions;

use Exception;

/**
 * Represents an exception that can be used to send a response
 */
class RestException extends Exception
{
    public $code = 500;
}
