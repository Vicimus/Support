<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

interface HasTerms
{
    /**
     * Get the term
     *
     * @return float
     */
    public function term(): float;
}
