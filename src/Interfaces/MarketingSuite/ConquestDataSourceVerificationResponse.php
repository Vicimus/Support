<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface ConquestDataSourceVerificationResponse
 */
interface ConquestDataSourceVerificationResponse
{
    /**
     * Is it valid
     */
    public function valid(): bool;
}
