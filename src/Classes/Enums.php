<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use function key_exists;

/**
 * Definitions that we can reuse for storing data or for display.
 */
class Enums
{
    /**
     * Return countries definitions
     *
     * @return string[]
     */
    public static function countries(): array
    {
        return [
            'CA' => 'Canada',
            'US' => 'United States',
        ];
    }

    /**
     * Return languages definitions
     *
     * @return string[]
     */
    public static function languages(): array
    {
        return [
            'en' => 'English',
            'fr' => 'Français',
        ];
    }

    /**
     * Return timezones definitions
     *
     * @return string[]
     */
    public static function timezones(): array
    {
        return [
            'PST' => 'PST - Pacific Time Zone',
            'MST' => 'MST - Mountain Time Zone',
            'CST' => 'CST - Central Time Zone',
            'EST' => 'EST - Eastern Time Zone',
            'ADT' => 'ADT - Atlantic Time Zone',
            'NST' => 'NST - Newfoundland Time Zone',
        ];
    }

    /**
     * Return vehicle mileageUnits definitions
     *
     * @return string[]
     */
    public static function mileageUnits(): array
    {
        return [
            'km' => 'Kilometers',
            'mi' => 'Miles',
        ];
    }

    /**
     * Return payments definitions
     *
     * @return string[]
     */
    public static function paymentTypes(): array
    {
        return [
            'cash' => 'Cash',
            'lease' => 'Lease',
            'finance' => 'Finance',
        ];
    }

    /**
     * Return vehicle sale class definitions
     *
     * @return string[]
     */
    public static function vehicleSaleClasses(): array
    {
        return [
            'new' => 'New',
            'used' => 'Used',
        ];
    }

    /**
     * Return states/provinces definitions
     *
     * @param string|null $country The country code to get states
     *
     * @return string[]|null
     */
    public static function states(?string $country = null): ?array
    {
        $states = [
            'CA' => [
                'AB' => 'Alberta',
                'BC' => 'British Columbia',
                'MB' => 'Manitoba',
                'NB' => 'New Brunswick',
                'NL' => 'Newfoundland and Labrador',
                'NS' => 'Nova Scotia',
                'NT' => 'Northwest Territories',
                'NU' => 'Nunavut',
                'ON' => 'Ontario',
                'PE' => 'Prince Edward Island',
                'QC' => 'Quebec',
                'SK' => 'Saskatchewan',
                'YT' => 'Yukon',
            ],
            'US' => [
                'AL' => 'Alabama',
                'AK' => 'Alaska',
                'AZ' => 'Arizona',
                'AR' => 'Arkansas',
                'CA' => 'California',
                'CO' => 'Colorado',
                'CT' => 'Connecticut',
                'DE' => 'Delaware',
                'DC' => 'District Of Columbia',
                'FL' => 'Florida',
                'GA' => 'Georgia',
                'HI' => 'Hawaii',
                'ID' => 'Idaho',
                'IL' => 'Illinois',
                'IN' => 'Indiana',
                'IA' => 'Iowa',
                'KS' => 'Kansas',
                'KY' => 'Kentucky',
                'LA' => 'Louisiana',
                'ME' => 'Maine',
                'MD' => 'Maryland',
                'MA' => 'Massachusetts',
                'MI' => 'Michigan',
                'MN' => 'Minnesota',
                'MS' => 'Mississippi',
                'MO' => 'Missouri',
                'MT' => 'Montana',
                'NE' => 'Nebraska',
                'NV' => 'Nevada',
                'NH' => 'New Hampshire',
                'NJ' => 'New Jersey',
                'NM' => 'New Mexico',
                'NY' => 'New York',
                'NC' => 'North Carolina',
                'ND' => 'North Dakota',
                'OH' => 'Ohio',
                'OK' => 'Oklahoma',
                'OR' => 'Oregon',
                'PA' => 'Pennsylvania',
                'RI' => 'Rhode Island',
                'SC' => 'South Carolina',
                'SD' => 'South Dakota',
                'TN' => 'Tennessee',
                'TX' => 'Texas',
                'UT' => 'Utah',
                'VT' => 'Vermont',
                'VA' => 'Virginia',
                'WA' => 'Washington',
                'WV' => 'West Virginia',
                'WI' => 'Wisconsin',
                'WY' => 'Wyoming',
            ],
        ];

        if (!$country) {
            return $states;
        } else {
            if (!key_exists($country, $states)) {
                return null;
            }
            return $states[$country];
        }
    }
}
