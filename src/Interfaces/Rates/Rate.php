<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Rates;

/**
 * Represents an interest rate for a specific term
 */
interface Rate
{
    /**
     * The term rate as a decimal
     *
     */
    public function rate(): float;

    /**
     * The term length in months
     *
     */
    public function term(): int;

    /**
     * Get the type of rate this is (finance, lease)
     *
     */
    public function type(): string;
}
