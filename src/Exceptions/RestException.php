<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Exception;
use JsonSerializable;

class RestException extends Exception implements JsonSerializable
{
    /**
     * @var int
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.PropertyTypeHint.MissingNativeTypeHint
     */
    public $code = 500;

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
