<?php

namespace Vicimus\Support\Classes;

use Vicimus\Support\Traits\ConsoleOutputter;

/**
 * Easily benchmark various aspects of a PHP script
 *
 * @author Jordan
 */
class Benchmark
{
    /**
     * This adds support for binding a ConsoleOutput interface and allowing
     * the instance of Benchmark to output information
     */
    use ConsoleOutputter;

    /**
     * Track the time the benchmark has started
     *
     * @var int
     */
    protected $start = 0;

    /**
     * Track the starting memory
     *
     * @var int
     */
    protected $init = 0;

    /**
     * Track the time when the benchmark has finished
     *
     * @var int
     */
    protected $stop = 0;

    /**
     * Track the amount of memory in use when the benchmark finished
     *
     * @var int
     */
    protected $dinit = 0;

    /**
     * Get the highest level of memory used during the benchmark
     *
     * @var int
     */
    protected $peak = 0;

    /**
     * Any custom benchmarking
     *
     * @var callable[]
     */
    protected $customs = [];

    /**
     * Begin the benchmarking
     *
     * @return Benchmark
     */
    public function init()
    {
        foreach ($this->customs as $custom) {
            $method = $custom['init'];
            $method($this);
        }

        $this->start = microtime(true);
        $this->init = memory_get_usage();
        return $this;
    }

    /**
     * Stop the benchmark
     *
     * @return Benchmark
     */
    public function stop()
    {
        $this->stop = microtime(true);
        $this->dinit = memory_get_usage();
        $this->peak = memory_get_peak_usage();

        foreach ($this->customs as &$custom) {
            $method = $custom['stop'];
            $custom['results'] = $method($this);
        }

        return $this;
    }

    /**
     * Add a custom benchmark
     *
     * @param callable $init The method to be called on init
     * @param callable $stop The method to be called on stop
     *
     * @return Benchmark
     */
    public function custom(callable $init, callable $stop)
    {
        $this->customs[] = [
            'init' => $init,
            'stop' => $stop,
        ];

        return $this;
    }

    /**
     * Output the benchmark statistics
     *
     * @return void
     */
    public function output()
    {
        $results = $this->get();
        $this->info('Time: '.$results['time']);
        $this->info('Memory: '.$results['memory']);
        $this->info('Peak: '.$results['peak']);

        foreach ($this->customs as $custom) {
            $this->info($custom['results']);
        }
    }

    /**
     * Get the statistics
     *
     * @return array
     */
    public function get()
    {
        $memory = round(($this->dinit - $this->init) / 1024 / 1024).'MB';
        $time = round($this->stop - $this->start, 2).'S';
        $peak = round($this->peak / 1024 / 1024).'MB';
        $customs = [];
        
        foreach ($this->customs as $custom) {
            $customs[] = $custom['results'];
        }

        return [
            'time'   => $time,
            'memory' => $memory,
            'peak'   => $peak,
            'customs' => $customs,
        ];
    }
}
