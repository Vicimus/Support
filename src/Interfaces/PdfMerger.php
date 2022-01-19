<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Exceptions\MergeException;

interface PdfMerger
{
    /**
     * Add a pdf string to be merged
     *
     * @param string      $content The content of a pdf file
     * @param string|null $name    Optionally, a name to assign the file
     * @param string|null $file    Optionally, the file path to use
     *
     * @return void
     */
    public function add(string $content, ?string $name = null, ?string $file = null): void;

    /**
     * Add a pdf file to be merged
     *
     * @param string      $file The file path to merge
     * @param string|null $name Optionally, a name to assign the file
     *
     * @throws \Vicimus\PDF\Exceptions\MergeException
     *
     * @return void
     */
    public function addFile(string $file, ?string $name = null): void;

    /**
     * How many files in the merger
     * @return int
     */
    public function count(): int;

    /**
     * The merger can look at the data and determine how many chunks it wants to make
     *
     * @param int $chunkSize     The chunk size
     * @param int $sizeOfOne     The size of one file
     * @param int $numberOfItems The total number of items
     *
     * @return int
     */
    public function getNumberOfChunks(int $chunkSize, int $sizeOfOne, int $numberOfItems): int;

    /**
     * Give the merger a chance to modify the storage method if required
     *
     * @param int $zipOrMerge The specified mode but the merger can change it
     *
     * @return int
     */
    public function getStorageMethod(int $zipOrMerge): int;

    /**
     * Merge all PDFs into a single PDF
     *
     * @param bool $returnRawContent Should return raw content or a file path
     * @return string
     *
     * @throws MergeException
     */
    public function merge(bool $returnRawContent = true): string;

    /**
     * Reset the merger
     *
     * @return static
     */
    public function reset(): PdfMerger;
}
