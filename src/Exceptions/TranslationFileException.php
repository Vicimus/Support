<?php

declare(strict_types=1);

namespace Vicimus\Support\Exceptions;

use Exception;

/**
 * Exception caught by the translator service when trying to create a file that
 * is not allowed.
 *
 * Catches typos in package/file names.
 */
class TranslationFileException extends Exception
{
    //
}
