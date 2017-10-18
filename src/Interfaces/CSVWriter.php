<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

/**
 * Establishes a contact for parsing CSVs
 *
 * @author Jordan Grieve
 */
interface CSVWriter
{
    /**
     * Write an array of data in CSV format
     *
     * @param string[] $rows The rows to write
     *
     * @return $this
     */
    public function write(array $rows): CSVWriter;

    /**
     * Writes the headers to the file
     *
     * @return $this
     */
    public function withHeaders(): CSVWriter;

    /**
     * Set the file to write to
     *
     * @param mixed $pathToFile The path to the file
     *
     * @return $this
     */
    public function file($pathToFile): CSVWriter;
}
