<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasTerm
 */
interface HasTerm
{
    /**
     * Get the term
     *
     */
    public function term(): float;
}
