<?php declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface ConquestDataSourceVerificationResponse
{
    /**
     * Is it valid
     * @return bool
     */
    public function valid(): bool;
}
