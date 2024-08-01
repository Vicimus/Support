<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Vicimus\Support\Interfaces\Vehicle;

class PhotoException extends RestException
{
    /**
     * The stock that threw the exception
     */
    protected Vehicle $stock;

    /**
     * THe url that threw the exception
     */
    protected string $url;

    public function __construct(Vehicle $stock, ?string $url, ?string $specific = null, int $code = 500)
    {
        $this->stock = $stock;
        $this->url = $url;

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
