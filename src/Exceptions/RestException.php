<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Exception;
use JsonSerializable;

/**
 * Represents an exception that can be used to send a response
 */
class RestException extends Exception implements JsonSerializable
{
    /**
     * The default error code
     *
     */
    public int $code = 500;

    /**
     * Specify data which should be serialized to JSON
     *
     * @return string[]
     */
    public function jsonSerialize(): array
    {
        return [
            'error' => $this->getMessage(),
            'code' => $this->code,
        ];
    }
}
