<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

interface HasLeaseRate extends HasRate
{
    /**
     * The lease residual value
     */
    public function residual(): float;
}
