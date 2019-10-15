<?php declare(strict_types = 1);

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
    public function __construct($original)
    {
        parent::__construct(array_merge(['spend' => null, 'total' => null], (array) $original));
    }
}
