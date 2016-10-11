<?php

namespace Vicimus\Support\Interfaces;

/**
 * Establishes a contact for parsing CSVs
 *
 * @author Jordan Grieve
 */
interface CSVParser
{
    /**
     * Parse a CSV file
     *
     * @param string $file The file to parse
     *
     * @return CSVParser
     */
    public function parse($file);

    /**
     * The rows that were parsed from the CSV
     *
     * @return mixed[]
     */
    public function content();

    /**
     * Set the headers to be used with the CSV data
     *
     * @return string[]
     */
    public function headers();
}
