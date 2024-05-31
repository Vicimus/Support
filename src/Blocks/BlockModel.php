<?php

declare(strict_types=1);

namespace Vicimus\Support\Blocks;

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
     */
    public function bindPageBlockInstance(int $pageId, ?BlockModel $model = null): BlockModel;

    /**
     * Get the block identifier
     *
     */
    public function blockIdentifier(): int;

    /**
     * Get the associated page block
     *
     */
    public function getInfo(): PageBlock;
}
