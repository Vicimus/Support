<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Onyx\Exceptions\OnyxException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\LocaleException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\TemplateException;

/**
 * Interface Placeholders
 */
interface Placeholders
{
    /**
     * Conditionals on elements
     *
     * @param string          $content The content
     * @param PlaceholderData $data    The placeholder data
     *
     * @throws OnyxException
     * @throws TemplateException
     */
    public function editorIfs(string $content, PlaceholderData $data): string;

    /**
     * If the placeholder is a custom, determine that it is formatted correctly with it's label
     *
     * @param string $placeholder The placeholder to check
     *
     */
    public function isValidCustomPlaceholder(string $placeholder): bool;

    /**
     * Check if a given placeholder is a valid placeholder
     *
     * @param string $placeholder      The placeholder to check
     * @param string $type             The type of campaign making the request
     * @param bool   $containsFallback Flag to indicate fallback is provided
     *
     */
    public function isValidPlaceholder(string $placeholder, string $type, bool $containsFallback): bool;

    /**
     * Get a placeholder value
     *
     * @param string          $placeholder The placeholder ie. {{DEALER.NAME}}
     * @param PlaceholderData $data        The placeholder data
     *
     * @throws TemplateException
     */
    public function placeholderValue(string $placeholder, PlaceholderData $data): string;

    /**
     * Extract all occurrences of placeholders within a string of content
     *
     * @param string $content The content to look through
     *
     * @return string[]
     */
    public function placeholders(?string $content): array;

    /**
     * Recursive replacement of placeholders
     *
     * @param string          $mapping The mapping
     * @param PlaceholderData $data    The placeholder data
     * @param string          $default The default value
     * @param int             $depth   The depth of recursion
     *
     * @throws TemplateException
     */
    public function recursive(string $mapping, PlaceholderData $data, string $default = '', int $depth = 0): string;

    /**
     * Set the locale
     *
     * @param string $locale The locale to set
     *
     *
     * @throws LocaleException
     */
    public function setLocale(string $locale): void;

    /**
     * Strip a placeholder and get it's real placeholder representative
     *
     * @param string $placeholder The placeholder to strip
     *
     */
    public function strip(string $placeholder): string;
}
