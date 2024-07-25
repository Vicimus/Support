<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

use stdClass;

interface Block
{
    /**
     * Get content in a dynamic way. This is what is called when front end
     * views have getDynamicContent in them
     */
    public function dynamic(BlockModel $model): string;

    /**
     * This method is the public facing method that is called by the
     * page blocks when your block is to be displayed. It calls your
     * overridden method content.
     */
    public function getContent(int $pageID, BlockModel $model, bool $publish = false): string;

    /**
     * Get a label for this block
     */
    public function getLabel(): string;

    /**
     * How many instances of your block can be on a single page
     */
    public function getLimit(): int;

    /**
     * Get an eloquent model to represent this block
     */
    public function getModel(BlockModel $model): BlockModel;

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
     * Get the raw model
     */
    public function getRawModel(): string;

    /**
     * Is the block managed
     */
    public function isManaged(): bool;

    /**
     * Check if a page is valid for this block
     */
    public function isPageValid(Page $page): bool;

    /**
     * Checks if the parent has children
     */
    public function isParent(): bool;

    /**
     * Path on the disk where this block layouts live
     */
    public function layoutPath(): string;

    /**
     * Get available layout information
     * @return string[][]
     */
    public function layouts(): array;

    /**
     * Get an array of available settings
     * @return string[][]
     */
    public function settings(): array;

    /**
     * Convert the instance into a json object
     */
    public function toFrontEnd(): stdClass;

    /**
     * Translate internal properties
     */
    public function translate(): void;
}
