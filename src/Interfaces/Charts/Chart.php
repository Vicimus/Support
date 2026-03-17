<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Charts;

use stdClass;

/**
 * Ensures basic implementation of charts
 */
interface Chart
{
    /**
     * Add data to the chart
     *
     * @param string[] $parameters The data to use to add a new data-point
     */
    public function add(array $parameters): Chart;

    /**
     * Must return a json_encodable structure representing options for the
     * chart.
     *
     * @return stdClass|string[]
     */
    public function options(): stdClass | array;

    /**
     * Get all markup required to make the chart show up on a page
     */
    public function output(): string;
}
