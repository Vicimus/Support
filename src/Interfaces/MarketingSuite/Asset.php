<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\AssetBuilder\Classes\CallToAction;
use Vicimus\AssetBuilder\Classes\Instruction;
use Vicimus\Support\Interfaces\MarketingSuite\Assets\Validator;
use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\TemplateException;

/**
 * Interface Asset
 *
 * @property string $template
 * @property mixed[] $tabs
 */
interface Asset extends AssetContract
{
    /**
     * Determine if an asset has been approved
     *
     */
    public function active(): bool;

    /**
     * Determine if an asset has been approved
     *
     */
    public function approved(): bool;

    /**
     * Retrieve the call to actions for the asset
     * @return CallToAction[]
     */
    public function callToActions(): array;

    /**
     * Get the height
     */
    public function height(): int;

    /**
     * Retrieve the instructions on the asset. This is not always populated
     * and generally is only populated when necessary and sending to the
     * PURL application
     *
     * @return Instruction[]
     */
    public function instructions(): array;

    /**
     * The intent of the Asset, conquest|retention
     */
    public function intent(): string;

    /**
     * Get the rendered markup
     */
    public function rendered(): string;

    /**
     * Convert the asset into an array that is easy to send over the network
     * @return mixed[]
     */
    public function toArray(): array;

    /**
     * Get the slug or type of asset this represents
     */
    public function type(): string;

    /**
     * Validate an asset
     *
     * @param string[]  $errors    The errors found
     * @param Validator $validator Optionally provide a validator to use
     *
     *
     * @throws TemplateException
     */
    public function validate(array &$errors = [], ?Validator $validator = null): bool;

    /**
     * The width of this asset
     */
    public function width(): int;
}
