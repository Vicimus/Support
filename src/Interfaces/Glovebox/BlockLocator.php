<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface BlockLocator
 */
interface BlockLocator
{
    /**
     * Get a block model
     *
     * @param int $pageId  The page id
     * @param int $blockId The block id
     *
     * @return BlockModel|null
     */
    public function getBlockModel(int $pageId, int $blockId): ?BlockModel;
}
