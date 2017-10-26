<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Rates;

/**
 * Represents an interest rate for a specific term
 */
interface Rate
{
    /**
     * The term rate as a decimal
     *
     * @return float
     */
    public function rate(): float;

    /**
     * The term length in months
     *
     * @return int
     */
    public function term(): int;

    /**
     * Get the type of rate this is (finance, lease)
     *
     * @return string
     */
    public function type(): string;
}
