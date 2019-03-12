<?php

namespace Vicimus\Support\Interfaces;

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
     * @return mixed
     *
     * @throws TranslationFileException
     */
    public function tran($key, $default = null, array $variables = []);
}
