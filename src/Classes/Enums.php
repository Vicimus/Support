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
     * Return countries definitions patterns
     *
     * @return string[]
     */
    public static function countriesPatterns(): array
    {
        return [
            'CA' => '/\b(ca|canada)\b/iu',
            'US' => '/\b(usa?|united[- ]states|[ée]tats[- ]unis)\b/iu',
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
     * Return languages definitions patterns
     *
     * @return string[]
     */
    public static function languagesPatterns(): array
    {
        return [
            'en' => '/\b(eng?|ang|english|anglais)\b/iu',
            'fr' => '/\b(fre?|fra|french|fran[çc]ais)\b/iu',
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
     * Return timezones definitions patterns
     *
     * @return string[]
     */
    public static function timezonesPatterns(): array
    {
        return [
            'PST' => '/\b(pst|pacific|pacifique)\b/iu',
            'MST' => '/\b(mst|mountains?|montagnes?)\b/iu',
            'CST' => '/\b(cst|central|centre)\b/iu',
            'EST' => '/\b(est|eastern)\b/iu',
            'ADT' => '/\b(adt|atlantic|atlantique)\b/iu',
            'NST' => '/\b(nst|newfoundland|terre[ -]neuve)\b/iu',
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
     * Return vehicle mileageUnits definitions patterns
     *
     * @return string[]
     */
    public static function mileageUnitsPatterns(): array
    {
        return [
            'km' => '/\b(kms?|kilometers?|kilom[èe]tres?)\b/iu',
            'mi' => '/\b(mi|miles?)\b/iu',
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
     * Return payments definitions patterns
     *
     * @return string[]
     */
    public static function paymentTypesPatterns(): array
    {
        return [
            'cash' => '/\b(cash|comptant)\b/iu',
            'lease' => '/\b(lease|location)\b/iu',
            'finance' => '/\b(finance(ment)?|financing)\b/iu',
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
     * Return vehicle sale class patterns
     *
     * @return string[]
     */
    public static function vehicleSaleClassesPatterns(): array
    {
        return [
            'new' => '/\b(new|neuf)\b/iu',
            'used' => '/\b(used|usag[eé]e?)\b/iu',
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

    /**
     * Return states patterns
     *
     * @param null|string $country The country input
     *
     * @return string[]|null
     */
    public static function statesPatterns(?string $country = null): ?array
    {
        $states = [
            'CA' => [
                'AB' => '/\b(AB|Alberta)\b/iu',
                'BC' => '/\b(BC|British Columbia)\b/iu',
                'MB' => '/\b(MB|Manitoba)\b/iu',
                'NB' => '/\b(NB|New Brunswick)\b/iu',
                'NL' => '/\b(NL|Newfoundland and Labrador)\b/iu',
                'NS' => '/\b(NS|Nova Scotia)\b/iu',
                'NT' => '/\b(NT|Northwest Territories)\b/iu',
                'NU' => '/\b(NU|Nunavut)\b/iu',
                'ON' => '/\b(ON|Ontario)\b/iu',
                'PE' => '/\b(PE|Prince Edward|Prince Édouard)\b/iu',
                'QC' => '/\b(QC|Qu[ée]bec)\b/iu',
                'SK' => '/\b(SK|Saskatchewan)\b/iu',
                'YT' => '/\b(YT|Yukon)\b/iu',
            ],
            'US' => [
                'AL' => '/\b(AL|Alabama)\b/iu',
                'AK' => '/\b(AK|Alaska)\b/iu',
                'AZ' => '/\b(AZ|Arizona)\b/iu',
                'AR' => '/\b(AR|Arkansas)\b/iu',
                'CA' => '/\b(CA|California)\b/iu',
                'CO' => '/\b(CO|Colorado)\b/iu',
                'CT' => '/\b(CT|Connecticut)\b/iu',
                'DE' => '/\b(DE|Delaware)\b/iu',
                'DC' => '/\b(DC|District Of Columbia)\b/iu',
                'FL' => '/\b(FL|Florida)\b/iu',
                'GA' => '/\b(GA|Georgia)\b/iu',
                'HI' => '/\b(HI|Hawaii)\b/iu',
                'ID' => '/\b(ID|Idaho)\b/iu',
                'IL' => '/\b(IL|Illinois)\b/iu',
                'IN' => '/\b(IN|Indiana)\b/iu',
                'IA' => '/\b(IA|Iowa)\b/iu',
                'KS' => '/\b(KS|Kansas)\b/iu',
                'KY' => '/\b(KY|Kentucky)\b/iu',
                'LA' => '/\b(LA|Louisiana)\b/iu',
                'ME' => '/\b(ME|Maine)\b/iu',
                'MD' => '/\b(MD|Maryland)\b/iu',
                'MA' => '/\b(MA|Massachusetts)\b/iu',
                'MI' => '/\b(MI|Michigan)\b/iu',
                'MN' => '/\b(MN|Minnesota)\b/iu',
                'MS' => '/\b(MS|Mississippi)\b/iu',
                'MO' => '/\b(MO|Missouri)\b/iu',
                'MT' => '/\b(MT|Montana)\b/iu',
                'NE' => '/\b(NE|Nebraska)\b/iu',
                'NV' => '/\b(NV|Nevada)\b/iu',
                'NH' => '/\b(NH|New Hampshire)\b/iu',
                'NJ' => '/\b(NJ|New Jersey)\b/iu',
                'NM' => '/\b(NM|New Mexico)\b/iu',
                'NY' => '/\b(NY|New York)\b/iu',
                'NC' => '/\b(NC|North Carolina)\b/iu',
                'ND' => '/\b(ND|North Dakota)\b/iu',
                'OH' => '/\b(OH|Ohio)\b/iu',
                'OK' => '/\b(OK|Oklahoma)\b/iu',
                'OR' => '/\b(OR|Oregon)\b/iu',
                'PA' => '/\b(PA|Pennsylvania)\b/iu',
                'RI' => '/\b(RI|Rhode Island)\b/iu',
                'SC' => '/\b(SC|South Carolina)\b/iu',
                'SD' => '/\b(SD|South Dakota)\b/iu',
                'TN' => '/\b(TN|Tennessee)\b/iu',
                'TX' => '/\b(TX|Texas)\b/iu',
                'UT' => '/\b(UT|Utah)\b/iu',
                'VT' => '/\b(VT|Vermont)\b/iu',
                'VA' => '/\b(VA|Virginia)\b/iu',
                'WA' => '/\b(WA|Washington)\b/iu',
                'WV' => '/\b(WV|West Virginia)\b/iu',
                'WI' => '/\b(WI|Wisconsin)\b/iu',
                'WY' => '/\b(WY|Wyoming)\b/iu',
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
