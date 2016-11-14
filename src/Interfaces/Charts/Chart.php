<?php

namespace Vicimus\Support\Interfaces\Charts;

/**
 * Ensures basic implementation of charts
 *
 * @author Jordan Grieve <jgrieve@vicimus.com>
 */
interface Chart
{
    /**
     * Get all markup required to make the chart show up on a page
     *
     * @return string
     */
    public function output();

    /**
     * Add data to the chart
     *
     * @param mixed $parameters The data to use to add a new datapoint
     *
     * @return Chart
     */
    public function add(array $parameters);

    /**
     * Must return a json_encodable structure representing options for the
     * chart.
     *
     * @return stdClass|array
     */
    public function options();
}
