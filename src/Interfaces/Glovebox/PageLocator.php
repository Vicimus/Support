<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface PageLocator
{
    /**
     * Find a page
     */
    public function find(int $pageId): ?Page;
}
