<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Illuminate\Support\Collection;

/**
 * Generic parser.
 *
 * @param Collection $conquest
 * @param Collection $retention
 */
class CalloutResponse extends ImmutableObject
{
    /**
     * CalloutResponse constructor.
     *
     * @param Collection $conquest  Collection of Conquest callouts
     * @param Collection $retention Collection of Retention callouts
     */
    public function __construct(Collection $conquest, Collection $retention)
    {
        parent::__construct([
            'conquest' => $conquest,
            'retention' => $retention,
        ]);
    }
}
