<?php

namespace Vicimus\Support\Traits;

use Vicimus\Support\Interfaces\ConsoleOutput;

trait ConsoleOutputter
{
    protected $output = null;

    public function info($output)
    {
        if ($this->output) {
            $this->output->info($output);
        }
    }

    public function error($output)
    {
        if ($this->output) {
            $this->output->error($output);
        }
    }

    public function comment($output)
    {
        if ($this->output) {
            $this->output->comment($output);
        }
    }

    public function line($output)
    {
        if ($this->output) {
            $this->output->line($output);
        }
    }

    public function bind(ConsoleOutput $output)
    {
        $this->output = $output;
        return $this;
    }
}