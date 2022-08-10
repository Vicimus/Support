<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces;

use InvalidArgumentException;
use JsonException;
use Vicimus\Support\Interfaces\Incentives\RateCollection;
use Vicimus\Support\Interfaces\Incentives\ResidualCollection;

/**
 * Incentives
 */
interface Incentives
{
    /**
     * Get the straight-up rate value as a string
     *
     * @param string $postalCode The postal code
     * @param string $vin        The vin
     * @param string $type       finance|lease
     *
     * @return string
     * @throws JsonException
     */
    public function rateValue(string $postalCode, string $vin, string $type): ?string;

    /**
     * Get rates for a VIN
     *
     * @param string $postalCode The postal code
     * @param string $vin        The vin
     * @param string $type       finance|lease
     *
     * @return RateCollection
     * @throws JsonException
     */
    public function rates(string $postalCode, string $vin, string $type = 'finance'): RateCollection;

    /**
     * Get residuals for a vin
     *
     * @param string $postalCode The postal code
     * @param string $vin        The vin to get residuals for
     *
     * @return ResidualCollection
     * @throws JsonException
     * @throws InvalidArgumentException
     */
    public function residuals(string $postalCode, string $vin): ResidualCollection;
}
