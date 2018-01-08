<?php declare(strict_types = 1);

namespace Vicimus\Support\Exceptions;

use Exception;
use Throwable;
use Vicimus\Support\Interfaces\Utility;

/**
 * Class UtilityException
 */
class UtilityException extends Exception
{
    /**
     * UtilityException constructor
     *
     * @param Utility   $utility  The utility that threw the exception
     * @param Throwable $original The message to send
     */
    public function __construct(Utility $utility, Throwable $original)
    {
        $message = sprintf(
            'Utility [%s] (%s) threw an exception during execution. The message: %s in file %s on line %s',
            $utility->name(),
            get_class($utility),
            $original->getMessage(),
            $original->getFile(),
            $original->getLine()
        );

        parent::__construct($message);
    }
}
