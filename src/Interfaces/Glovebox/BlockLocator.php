<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface BlockLocator
{
    public function getBlockModel(int $pageId, int $blockId): ?BlockModel;
}
