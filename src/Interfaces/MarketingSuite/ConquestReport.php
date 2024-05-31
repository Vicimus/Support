<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface ConquestReport
 */
interface ConquestReport
{
    /**
     * Add report data to the report
     *
     * @param string  $source The source this is coming from
     * @param mixed[] $data   The data to add
     *
     */
    public function add(string $source, array $data): void;
}
