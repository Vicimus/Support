<?php declare(strict_types = 1);

/**
 * Translate the given message.
 *
 * @param string   $key     The translation file key
 * @param string   $default The default value
 * @param string[] $replace The array of variables
 * @param string   $locale  The locale
 *
 * @return string|string[]|null
 *
 * phpcs:disable
 */
function ___(string $key, ?string $default = null, array $replace = [], ?string $locale = null)
{
    $result = __($key, $replace, $locale);
    if ($result === $key) {
        if (strpos($default ?? '', ':') === false) {
            return $default;
        }

        foreach ($replace as $search => $instance) {
            $default = str_replace(':' . $search, $instance, $default);
        }

        return $default;
    }

    return $result;
}
