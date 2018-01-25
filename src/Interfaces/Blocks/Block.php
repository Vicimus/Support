<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Blocks;

use Illuminate\Database\Eloquent\Model;
use stdClass;
use Vicimus\Eevee\Models\Block as BlockModel;

/**
 * Interface Block
 */
interface Block
{
    /**
     * How many instances of your block can be on a single page
     *
     * @return int
     */
    public function getLimit(): int;

    /**
     * Get an eloquent model to represent this block
     *
     * @param BlockModel $model The raw model row
     *
     * @return Model
     */
    public function getModel(BlockModel $model): Model;

    /**
     * Get the name of the block
     *
     * @return string
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
     *
     * @return string
     */
    public function layoutPath(): string;

    /**
     * Get available layout information
     *
     * @return mixed[]
     */
    public function layouts(): array;

    /**
     * Convert the instance into a json object
     *
     * @return stdClass
     */
    public function toFrontEnd(): stdClass;

    /**
     * Translate internal properties
     *
     * @return void
     */
    public function translate(): void;
}
