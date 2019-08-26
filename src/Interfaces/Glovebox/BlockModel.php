<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

use Vicimus\Eevee\Models\Joins\PageBlock;

/**
 * Interface Block
 */
interface BlockModel
{
    /**
     * Bind the page block to the model by passing the page id and the blocks
     * model instance.
     *
     * @param int             $pageId The Page the block is on
     * @param BlockModel|null $model  The model to force a bind with
     *
     * @return BlockModel
     */
    public function bindPageBlockInstance(int $pageId, ?BlockModel $model = null): BlockModel;

    /**
     * Get the block identifier
     *
     * @return int
     */
    public function blockIdentifier(): int;

    /**
     * Get the associated page block
     *
     * @return PageBlock
     */
    public function getInfo(): PageBlock;
}
