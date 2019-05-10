<?php declare(strict_types = 1);

namespace Vicimus\Support\Equity;

/**
 * Error codes for equity
 */
abstract class ErrorCodes
{
    /** Invalid parameters were sent */
    public const INVALID_PARAMS = 4;

    /** No results found for parameters */
    public const NO_RESULTS = 5;

    /** Successful valuation */
    public const SUCCESS = 0;

    /** Unknown result */
    public const UNSPECIFIED_RESULT = 2;

    /** Returned multiple vehicles so no value */
    public const RETURNED_MULTIPLE = 3;
}
