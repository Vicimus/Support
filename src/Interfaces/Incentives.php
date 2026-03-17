<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces;

use Vicimus\Support\Interfaces\Incentives\RateCollection;
use Vicimus\Support\Interfaces\Incentives\ResidualCollection;

interface Incentives
{
    public function rateValue(string $postalCode, string $vin, string $type): ?string;

    public function rates(string $postalCode, string $vin, string $type = 'finance'): RateCollection;

    public function residuals(string $postalCode, string $vin): ResidualCollection;
}
