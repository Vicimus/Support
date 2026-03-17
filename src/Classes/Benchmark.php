<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Vicimus\Support\Traits\ConsoleOutputter;

class Benchmark
{
    use ConsoleOutputter;

    /**
     * Any custom benchmarking
     * @var callable[]
     */
    protected array $customs = [];

    protected int $dinit = 0;

    protected int $init = 0;

    protected int $peak = 0;

    protected float $start = 0;

    protected float $stop = 0;

    public function custom(callable $init, callable $stop): Benchmark
    {
        $this->customs[] = [
            'init' => $init,
            'stop' => $stop,
        ];

        return $this;
    }

    /**
     * @return string[]
     */
    public function get(): array
    {
        $memory = round(($this->dinit - $this->init) / 1024 / 1024) . 'MB';
        $time = round($this->stop - $this->start, 2) . 'S';
        $peak = round($this->peak / 1024 / 1024) . 'MB';
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

    public function init(): Benchmark
    {
        foreach ($this->customs as $custom) {
            $method = $custom['init'];
            $method($this);
        }

        $this->start = microtime(true);
        $this->init = memory_get_usage();
        return $this;
    }

    public function output(): void
    {
        $results = $this->get();
        $this->info('Time: ' . $results['time']);
        $this->info('Memory: ' . $results['memory']);
        $this->info('Peak: ' . $results['peak']);

        foreach ($this->customs as $custom) {
            $this->info($custom['results']);
        }
    }

    public function stop(): Benchmark
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
}
