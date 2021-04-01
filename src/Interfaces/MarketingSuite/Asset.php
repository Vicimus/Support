<?php declare(strict_types = 1);

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
     * @return bool
     */
    public function active(): bool;

    /**
     * Determine if an asset has been approved
     *
     * @return bool
     */
    public function approved(): bool;

    /**
     * Retrieve the call to actions for the asset
     * @return CallToAction[]
     */
    public function callToActions(): array;

    /**
     * The intent of the Asset, conquest|retention
     * @return string
     */
    public function intent(): string;

    /**
     * Retrieve the instructions on the asset. This is not always populated
     * and generally is only populated when necessary and sending to the
     * PURL application
     *
     * @return Instruction[]
     */
    public function instructions(): array;

    /**
     * Get the rendered markup
     * @return string
     */
    public function rendered(): string;

    /**
     * Convert the asset into an array that is easy to send over the network
     * @return mixed[]
     */
    public function toArray(): array;

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
