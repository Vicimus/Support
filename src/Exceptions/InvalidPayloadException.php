<?php declare(strict_types = 1);

namespace Vicimus\Support\Exceptions;

use InvalidArgumentException as InvalidArgument;

use function get_class;
use function is_object;

/**
 * Class InvalidArgumentException
 */
class InvalidPayloadException extends InvalidArgument
{
    /**
     * InvalidArgumentException constructor
     *
     * @param mixed          $got           The argument that was invalid
     * @param string         $parameter     The parameter we want to describe
     * @param string[]|mixed ...$acceptable What would have been acceptable
     */
    public function __construct($got, string $parameter, ...$acceptable)
    {
        if ($parameter) {
            $parameter = sprintf(' for %s parameter', $parameter);
        }

        $type = is_object($got) ? get_class($got) : gettype($got);
        $message = sprintf(
            'Invalid argument supplied. Received %s but expected %s%s',
            $type,
            implode(', ', $acceptable),
            $parameter
        );

        parent::__construct($message, 500);
    }
}
