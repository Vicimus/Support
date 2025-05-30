<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use Illuminate\Support\Collection;

/**
 * @param Collection $conquest
 * @param Collection $retention
 */
class CalloutResponse extends ImmutableObject
{
    public function __construct(
        Collection $conquest,
        Collection $retention
    ) {
        parent::__construct([
            'conquest' => $conquest,
            'retention' => $retention,
        ]);
    }
}
