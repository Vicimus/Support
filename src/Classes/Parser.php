<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use function preg_match;

class Parser
{
    public static function parseCountry(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::countriesPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected language.
     */
    public static function parseLanguage(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::languagesPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected mileage unit.
     */
    public static function parseMileageUnit(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::mileageUnitsPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected payment types.
     */
    public static function parsePaymentType(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        $simple = Enums::getSimplePaymentTypes();
        $mapped = $simple[strtoupper($input)] ?? '';
        if ($mapped) {
            return $mapped;
        }

        foreach (Enums::paymentTypesPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected state.
     */
    public static function parseState(?string $input, ?string $country): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::statesPatterns($country) as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected timezone.
     */
    public static function parseTimezone(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::timezonesPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected make.
     */
    public static function parseVehicleMake(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::vehicleMakesPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }

    /**
     * Parse a string and return detected sale class.
     */
    public static function parseVehicleSaleClass(?string $input): ?string
    {
        if ($input === null) {
            return null;
        }

        foreach (Enums::vehicleSaleClassesPatterns() as $key => $pattern) {
            if (preg_match($pattern, $input)) {
                return $key;
            }
        }

        return null;
    }
}
