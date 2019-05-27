<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Assets;

use Vicimus\Support\Interfaces\MarketingSuite\Asset;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\TemplateException;

/**
 * Interface Validator
 */
interface Validator
{
    /**
     * Check if content contains invalid placeholders
     *
     * @param string   $content The content to validate
     * @param string[] $invalid The matches found
     *
     * @return bool
     */
    public function hasInvalidPlaceholders(?string $content, array &$invalid = []): bool;

    /**
     * Validate an asset
     *
     * @param Asset    $asset  The asset to validate
     * @param string[] $errors The errors array to fill with info
     *
     * @return bool
     *
     * @throws TemplateException
     */
    public function validate(Asset $asset, array &$errors): bool;
}
