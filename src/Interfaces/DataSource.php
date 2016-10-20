<?php

namespace Vicimus\Support\Interfaces;

/**
 * Forces specific behaviour from data sources
 *
 * @author Jordan
 */
interface DataSource
{
    /**
     * Return a slug to identify the data source as unique
     *
     * @return string
     */
    public function slug();

    /**
     * Return a wonderful name for your data source
     *
     * @return string
     */
    public function name();

    /**
     * Return an array of data points
     *
     * @return mixed[]
     */
    public function points();

    /**
     * Handle a data point request
     *
     * @param string $point      The point requested
     * @param array  $userParams The parameters to pass along
     *
     * @return mixed
     */
    public function handle($point, array $userParams = array());
}
