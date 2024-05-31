<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Financial;

/**
 * Interface LeaseVehicle
 */
interface LeaseItem extends HasDownpayment, HasIncentive, HasPrice, HasTerm, HasLeaseRate
{
    //
}
