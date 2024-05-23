<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

/**
 * Class ConquestBudget
 *
 * @property int $spend
 * @property int $total
 */
class ConquestBudget extends ImmutableObject
{
    /**
     * ConquestBudget constructor.
     *
     * @param mixed|mixed[] $original The original data
     */
    public function __construct(mixed $original)
    {
        parent::__construct(array_merge(['spend' => null, 'total' => null], (array) $original));
    }

    /**
     * Set the spend for a budget
     *
     * @param float $spend The spend to set
     *
     */
    public function setSpend(float $spend): void
    {
        $this->attributes['spend'] = $spend;
    }
}
