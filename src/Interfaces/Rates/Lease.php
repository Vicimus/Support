<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Rates;

use Vicimus\Support\Interfaces\HasRates;

interface Lease extends HasRates
{
    public function residual(): float;
}
