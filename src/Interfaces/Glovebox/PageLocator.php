<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

/**
 * Interface PageLocator
 */
interface PageLocator
{
    /**
     * Find a page
     *
     * @param int $pageId The page id to find
     *
     * @return Page|null
     */
    public function find(int $pageId): ?Page;
}
