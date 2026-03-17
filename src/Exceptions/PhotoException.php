<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Vicimus\Support\Interfaces\Vehicle;

class PhotoException extends RestException
{
    public function __construct(
        protected readonly Vehicle $stock,
        protected readonly ?string $url,
        ?string $specific = null,
        int $code = 500,
    ) {
        $message = sprintf('Error with %s', $stock->getStockNumber());
        if ($specific) {
            $format = 'Error with %s: %s';
            if ($url) {
                $format .= "\n" . 'URL: %s';
            }

            $message = sprintf(
                $format,
                $stock->getStockNumber(),
                $specific,
                $url
            );
        }

        parent::__construct($message, $code);
    }
}
