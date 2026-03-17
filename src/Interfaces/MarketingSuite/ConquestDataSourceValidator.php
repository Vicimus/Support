<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\BudgetException;

interface ConquestDataSourceValidator
{
    /**
     * Validate a Campaigns assets
     *
     * @return string[]
     */
    public function assets(Validatable $campaign): array;

    /**
     * Validate a budget
     *
     * @throws BudgetException
     */
    public function budget(Audience $audience, SourceRecord $source, int $amount): void;
}
