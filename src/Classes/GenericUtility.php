<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Throwable;
use Vicimus\Support\Exceptions\UtilityException;
use Vicimus\Support\Interfaces\Utility;

class GenericUtility implements Utility
{
    /**
     * @var callable
     */
    protected $call;

    protected string $desc;

    protected string $name;

    public function __construct(string $name, string $desc, callable $call)
    {
        $this->name = $name;
        $this->desc = $desc;
        $this->call = $call;
    }

    /**
     * Called to execute the utility
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @param mixed[] $flags Optional flags to pass along
     *
     * @throws UtilityException
     */
    public function call(?array $flags = null): mixed
    {
        $method = $this->call;
        try {
            return $this->results($method($flags));
        } catch (Throwable $ex) {
            throw new UtilityException($this, $ex);
        }
    }

    public function description(): string
    {
        return $this->desc;
    }

    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function options(): array
    {
        return [];
    }

    public function prompt(): string
    {
        return '';
    }

    /**
     * To be displayed after a call, to show the results of the call
     */
    public function results(mixed $payload = null): mixed
    {
        return $payload;
    }
}
