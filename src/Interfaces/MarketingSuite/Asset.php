<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\AssetBuilder\Classes\CallToAction;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\Validator;
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
     * Retrieve the call to actions for the asset
     * @return CallToAction[]
     */
    public function callToActions(): array;

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
     * @param string[]  $errors    The errors found
     * @param Validator $validator Optionally provide a validator to use
     *
     * @return bool
     *
     * @throws TemplateException
     */
    public function validate(array &$errors = [], ?Validator $validator = null): bool;
}
