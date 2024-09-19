<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Exceptions\MergeException;

/**
 * A pdf merger is a class that can take multiple pdfs and merge them into one file
 * through a variety of methods, including zip them up into a single file, or merge
 * them all into one single master file.
 */
interface PdfMerger
{
    /**
     * Add a pdf string to be merged
     */
    public function add(string $content, ?string $name = null, ?string $file = null): void;

    /**
     * Add a pdf file to be merged
     * @throws MergeException
     */
    public function addFile(string $file, ?string $name = null): void;

    /**
     * How many files in the merger
     */
    public function count(): int;

    /**
     * The merger can look at the data and determine how many chunks it wants to make
     */
    public function getNumberOfChunks(int $chunkSize, int $sizeOfOne, int $numberOfItems): int;

    /**
     * Give the merger a chance to modify the storage method if required
     */
    public function getStorageMethod(int $zipOrMerge): int;

    /**
     * Merge all PDFs into a single PDF
     * @throws MergeException
     */
    public function merge(bool $returnRawContent = true): string;

    /**
     * Reset the merger
     */
    public function reset(): PdfMerger;
}
