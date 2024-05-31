<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use function preg_match;

/**
 * Generic parser.
 */
class Parser
{
    /**
     * Parse a string and return detected country.
     *
     * @param string $input The country input
     *
     */
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
     *
     * @param string $input The language input
     *
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
     *
     * @param string $input The mileage unit input
     *
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
     *
     * @param string $input The payment type input
     *
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
     *
     * @param string $input   The state input
     * @param string $country In which country
     *
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
     *
     * @param string $input The timezone input
     *
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
     *
     * @param string $input The make input
     *
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
     *
     * @param string $input The sale class input
     *
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
