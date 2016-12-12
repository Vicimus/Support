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
     * @param string $file    The file to parse
     * @param array  $options Any options to set
     *
     * @return CSVParser
     */
    public function parse($file, array $options = array());

    /**
     * The rows that were parsed from the CSV
     *
     * @return mixed[]
     */
    public function content();

    /**
     * Set the headers to be used with the CSV data
     *
     * @param array $headers The headers to set the columns to
     *
     * @return string[]
     */
    public function headers(array $headers);

    /**
     * Make an instance of the parser but dont parse
     *
     * @param string $file    The file to parse
     * @param array  $options Any options to set
     *
     * @return CSVParser
     */
    public function make($file, array $options = array());

    /**
     * Iterate over each row of the CSV, one at a time
     *
     * @return string[]
     */
    public function each();

    /**
     * Get the hash value of the file specified in the parser
     *
     * @return string
     */
    public function hash();
}
