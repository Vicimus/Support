<?php declare(strict_types = 1);

/**
 * Translate the given message.
 *
 * @param  string  $key     The translation file key
 * @param  string  $default The default value
 * @param  array   $replace The array of variables
 * @param  string  $locale  The locale
 *
 * @return string|array|null
 */
function ___($key, $default, $replace = [], $locale = null)
{
    $result = __($key, $replace, $locale);
    if ($result === $key) {
        return $default;
    }

    return $result;
}
