<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

/**
 * Establishes a contact for parsing CSVs
 */
interface CSVWriter
{
    /**
     * Set the file to write to
     *
     * @param string $pathToFile The path to the file
     *
     */
    public function file(string $pathToFile): CSVWriter;

    /**
     * Writes the headers to the file
     *
     */
    public function withHeaders(): CSVWriter;

    /**
     * Write an array of data in CSV format
     *
     * @param string[] $rows The rows to write
     *
     */
    public function write(array $rows): CSVWriter;
}
