<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Blocks;

use Illuminate\Database\Eloquent\Model;
use stdClass;
use Vicimus\Support\Interfaces\Glovebox\BlockModel;

/**
 * Interface Block
 */
interface Block
{
    /**
     * How many instances of your block can be on a single page
     */
    public function getLimit(): int;

    /**
     * Get an eloquent model to represent this block
     */
    public function getModel(BlockModel $model): Model;

    /**
     * Get the name of the block
     */
    public function getName(): string;

    /**
     * Returns an array of page types this block is allowed on
     *
     * @return string[]
     */
    public function getPageTypes(): array;

    /**
     * Path on the disk where this block layouts live
     */
    public function layoutPath(): string;

    /**
     * Get available layout information
     *
     * @return string[][]
     */
    public function layouts(): array;

    /**
     * Convert the instance into a json object
     */
    public function toFrontEnd(): stdClass;

    /**
     * Translate internal properties
     */
    public function translate(): void;
}
