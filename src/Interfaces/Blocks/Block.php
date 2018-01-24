<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Blocks;

use stdClass;

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
