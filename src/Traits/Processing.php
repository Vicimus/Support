<?php

declare(strict_types=1);

namespace Vicimus\Support\Traits;

use Vicimus\Support\Interfaces\Processor;

trait Processing
{
    /**
     * Holds the options for the processor
     * @var string[]
     */
    protected array $options = [];

    /**
     * Set the options for this service
     *
     * @param string[] $options The options to set
     */
    public function options(array $options): Processor
    {
        $this->options = array_merge($this->options, $options);
        return $this;
    }

    public function option(string $name): mixed
    {
        if (!array_key_exists($name, $this->options)) {
            return null;
        }

        return $this->options[$name];
    }

    public function priority(): int
    {
        return 5;
    }
}
