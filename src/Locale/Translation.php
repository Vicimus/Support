<?php declare(strict_types = 1);

namespace Vicimus\Support\Locale;

use Vicimus\Support\Classes\ImmutableObject;

/**
 * @property string $key
 * @property string[]|string $value
 * @property string $path
 * @property string $context
 * @property string[][] $locations
 * @property bool $translated
 */
class Translation extends ImmutableObject
{
    /**
     * @param string                     $key         The key (banana))
     * @param string|string[]|string[][] $translation The translation data
     * @param string|null                $path        The path (inventory-ads.banana))
     */
    public function __construct(string $key, $translation, ?string $path = null)
    {
        $path ??= $key;
        $value = $translation;
        $context = '';
        $locations = [];
        $translated = false;

        $locationIndex = 1;
        $contextIndex = 2;
        $translatedIndex = 3;

        if (!is_string($value)) {
            $value = $value[0];
            if (is_array($value)) {
                $locationIndex--;
                $contextIndex--;
                $value = $key;
            }

            $context = $translation[$contextIndex] ?? '';
            $locations = $translation[$locationIndex] ?? [];
            $translated = $translation[$translatedIndex] ?? false;
        }

        parent::__construct([
            'path' => $path,
            'key' => $key,
            'value' => $value,
            'context' => $context,
            'locations' => $locations,
            'translated' => $translated,
        ]);
    }
}
