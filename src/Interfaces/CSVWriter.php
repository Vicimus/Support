<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Establishes a contract for parsing CSVs
 */
interface CSVWriter
{
    /**
     * Set the file to write to
     */
    public function file(string $pathToFile): CSVWriter;

    /**
     * Writes the headers to the file
     */
    public function withHeaders(): CSVWriter;

    /**
     * Write an array of data in CSV format
     *
     * @param string[] $rows The rows to write
     */
    public function write(array $rows): CSVWriter;
}
