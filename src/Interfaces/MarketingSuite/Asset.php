<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\TemplateException;

/**
 * Interface Asset
 *
 * @property string $template
 * @property mixed[] $tabs
 */
interface Asset
{
    /**
     * Get the rendered markup
     * @return string
     */
    public function rendered(): string;

    /**
     * Get the slug or type of asset this represents
     * @return string
     */
    public function type(): string;

    /**
     * Validate an asset
     *
     * @param string[] $errors The errors found
     *
     * @return bool
     *
     * @throws TemplateException
     */
    public function validate(array &$errors = []): bool;
}
