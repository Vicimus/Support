<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Vicimus\Support\Exceptions\TranslationFileException;

/**
 * Interface Translator
 */
interface Translator
{
    /**
     * Translate a string
     *
     * @param string   $key       The key to find
     * @param string   $default   The default to use if not found
     * @param string[] $variables Any variables to use for placeholders
     *
     *
     * @throws TranslationFileException
     */
    public function tran(string $key, ?string $default = null, array $variables = []): mixed;
}
