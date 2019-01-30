<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface HasLeaseRate
 */
interface HasLeaseRate extends HasRate
{
    /**
     * The lease residual value
     *
     * @return float
     */
    public function residual(): float;
}
