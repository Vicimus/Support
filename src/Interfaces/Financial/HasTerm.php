<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasTerm
 */
interface HasTerm
{
    /**
     * Get the term
     *
     * @return float
     */
    public function term(): float;
}
