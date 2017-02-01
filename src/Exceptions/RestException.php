<?php

namespace Vicimus\Support\Exceptions;

/**
 * Represents an exception that can be used to send a response
 */
class RestException extends \Exception
{
    public $code = 500;
}