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
     * @param array $rows The rows to write
     *
     * @return $this
     */
    public function write(array $rows);

    /**
     * Writes the headers to the file
     *
     * @return $this
     */
    public function withHeaders();

    /**
     * Set the file to write to
     *
     * @return $this
     */
    public function file($pathToFile);
}
