<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\LocaleException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\OnyxException;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\TemplateException;

/**
 * Interface Placeholders
 */
interface Placeholders
{
    /**
     * Conditionals on elements
     * @throws OnyxException
     * @throws TemplateException
     */
    public function editorIfs(string $content, PlaceholderData $data): string;

    /**
     * If the placeholder is a custom, determine that it is formatted correctly with it's label
     */
    public function isValidCustomPlaceholder(string $placeholder): bool;

    /**
     * Check if a given placeholder is a valid placeholder
     */
    public function isValidPlaceholder(string $placeholder, string $type, bool $containsFallback): bool;

    /**
     * Get a placeholder value
     * @throws TemplateException
     */
    public function placeholderValue(string $placeholder, PlaceholderData $data): string;

    /**
     * Extract all occurrences of placeholders within a string of content
     * @return string[]
     */
    public function placeholders(?string $content): array;

    /**
     * Recursive replacement of placeholders
     * @throws TemplateException
     */
    public function recursive(string $mapping, PlaceholderData $data, string $default = '', int $depth = 0): string;

    /**
     * Set the locale
     *
     * @throws LocaleException
     */
    public function setLocale(string $locale): void;

    /**
     * Strip a placeholder and get it's real placeholder representative
     */
    public function strip(string $placeholder): string;
}
