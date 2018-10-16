<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Charts;

/**
 * Ensures basic implementation of charts
 */
interface Chart
{
    /**
     * Add data to the chart
     *
     * @param string[] $parameters The data to use to add a new data-point
     *
     * @return Chart
     */
    public function add(array $parameters): Chart;

    /**
     * Must return a json_encodable structure representing options for the
     * chart.
     *
     * @return \stdClass|string[]
     */
    public function options();

    /**
     * Get all markup required to make the chart show up on a page
     *
     * @return string
     */
    public function output(): string;
}
