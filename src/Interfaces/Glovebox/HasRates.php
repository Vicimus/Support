<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Glovebox;

interface HasRates
{
    /**
     * Retrieve the rate values of all rates for this vehicle.
     *
     * @phpcsSuppress SlevomatCodingStandard.TypeHints.DisallowMixedTypeHint
     *
     * @return mixed[][]|mixed[]
     */
    public function getAllRates(bool $lease = false): array;
}
