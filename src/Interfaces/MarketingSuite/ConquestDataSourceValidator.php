<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Interfaces\MarketingSuite\Exceptions\BudgetException;

/**
 * Interface ConquestDataSourceValidator
 */
interface ConquestDataSourceValidator
{
    /**
     * Validate a budget
     *
     * @param Audience     $audience The audience
     * @param SourceRecord $source   The source
     * @param int          $amount   The amount
     *
     * @throws BudgetException
     *
     * @return void
     */
    public function budget(Audience $audience, SourceRecord $source, int $amount): void;
}
