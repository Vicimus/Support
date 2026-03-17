<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

interface CSVParser
{
    /**
     * The rows that were parsed from the CSV
     *
     * @return string[][]
     */
    public function content(): array;

    /**
     * Iterate over each row of the CSV, one at a time
     *
     * @return iterable<string>
     */
    public function each(): iterable;

    /**
     * Get the hash value of the file specified in the parser
     */
    public function hash(): string;

    /**
     * Set the headers to be used with the CSV data
     *
     * @param string[] $headers The headers to set the columns to
     */
    public function headers(array $headers): CSVParser;

    /**
     * Make an instance of the parser but dont parse
     *
     * @param string   $file    The file to parse
     * @param string[] $options Any options to set
     */
    public function make(string $file, array $options = []): CSVParser;

    /**
     * Parse a CSV file
     *
     * @param string   $file    The file to parse
     * @param string[] $options Any options to set
     */
    public function parse(string $file, array $options = []): CSVParser;
}
