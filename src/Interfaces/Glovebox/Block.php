<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Glovebox;

use stdClass;
use Vicimus\Eevee\Models\Page;

/**
 * Interface Block
 */
interface Block
{
    /**
     * Get content in a dynamic way. This is what is called when front end
     * views have getDynamicContent in them
     *
     * @param BlockModel $model The model of the block
     *
     * @return string
     */
    public function dynamic(BlockModel $model): string;

    /**
     * This method is the public facing method that is called by the
     * page blocks when your block is to be displayed. It calls your
     * overridden method content.
     *
     * @param int        $pageID  The Page ID of the page publishing
     * @param BlockModel $model   The model representing the block instance
     * @param bool       $publish Publishing or edit-mode display
     *
     * @return string
     */
    public function getContent(int $pageID, BlockModel $model, bool $publish = false): string;

    /**
     * Get a label for this block
     *
     * @return string
     */
    public function getLabel(): string;

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
     * @return BlockModel
     */
    public function getModel(BlockModel $model): BlockModel;

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
     * Get the raw model
     *
     * @return string
     */
    public function getRawModel(): string;

    /**
     * Is the block managed
     *
     * @return bool
     */
    public function isManaged(): bool;

    /**
     * Check if a page is valid for this block
     *
     * @param Page $page The page to check against
     *
     * @return bool
     */
    public function isPageValid(Page $page): bool;

    /**
     * Checks if the parent has children
     *
     * @return bool
     */
    public function isParent(): bool;

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
     * Get an array of available settings
     *
     * @return mixed[]
     */
    public function settings(): array;

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
