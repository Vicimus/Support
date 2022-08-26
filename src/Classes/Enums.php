<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use function key_exists;

/**
 * Definitions that we can reuse for storing data or for display.
 */
class Enums
{
    const STATES = [
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
            'UK' => '/\b(uk|united[- ]kingdom\b/iu',
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
     * Return states/provinces definitions
     *
     * @param string|null $country The country code to get states
     *
     * @return string[]|null
     */
    public static function states(?string $country = null): ?array
    {
        if (!$country) {
            return $states;
        }

        if (!key_exists($country, $states)) {
            return null;
        }

        return self::STATES[$country];
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
        }

        if (!key_exists($country, $states)) {
            return [];
        }

        return $states[$country];
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
     * Return vehicle makes definitions
     *
     * @return string[]
     */
    public static function vehicleMakes(): array
    {
        return [
            'Acura' => 'Acura',
            'Alfa Romeo' => 'Alfa Romeo',
            'Aston Martin' => 'Aston Martin',
            'Audi' => 'Audi',
            'Bentley' => 'Bentley',
            'BMW' => 'BMW',
            'Bugatti' => 'Bugatti',
            'Buick' => 'Buick',
            'Cadillac' => 'Cadillac',
            'Chevrolet' => 'Chevrolet',
            'Chrysler' => 'Chrysler',
            'Dodge' => 'Dodge',
            'Ferrari' => 'Ferrari',
            'Fiat' => 'Fiat',
            'Ford' => 'Ford',
            'Geo' => 'Geo',
            'GMC' => 'GMC',
            'Honda' => 'Honda',
            'Hummer' => 'Hummer',
            'Hyundai' => 'Hyundai',
            'Infiniti' => 'Infiniti',
            'Isuzu' => 'Isuzu',
            'Jaguar' => 'Jaguar',
            'Jeep' => 'Jeep',
            'Kia' => 'Kia',
            'Lamborghini' => 'Lamborghini',
            'Land Rover' => 'Land Rover',
            'Lexus' => 'Lexus',
            'Lincoln' => 'Lincoln',
            'Lotus' => 'Lotus',
            'Maserati' => 'Maserati',
            'Maybach' => 'Maybach',
            'Mazda' => 'Mazda',
            'McLaren' => 'McLaren',
            'Mercedes-Benz' => 'Mercedes-Benz',
            'Mercury' => 'Mercury',
            'MG' => 'MG',
            'MINI' => 'MINI',
            'Mitsubishi' => 'Mitsubishi',
            'Nissan' => 'Nissan',
            'Oldsmobile' => 'Oldsmobile',
            'Peugeot' => 'Peugeot',
            'Plymouth' => 'Plymouth',
            'Pontiac' => 'Pontiac',
            'Porsche' => 'Porsche',
            'RAM' => 'RAM',
            'Renault' => 'Renault',
            'Rolls-Royce' => 'Rolls-Royce',
            'Saab' => 'Saab',
            'Saturn' => 'Saturn',
            'Scion' => 'Scion',
            'Smart' => 'Smart',
            'Subaru' => 'Subaru',
            'Suzuki' => 'Suzuki',
            'Tesla' => 'Tesla',
            'Toyota' => 'Toyota',
            'Volkswagen' => 'Volkswagen',
            'Volvo' => 'Volvo',
        ];
    }

    /**
     * Return vehicle makes patterns
     *
     * @return string[]
     */
    public static function vehicleMakesPatterns(): array
    {
        return [
            'Acura' => '/\b(Acura)\b/iu',
            'Alfa Romeo' => '/\b(Alfa[ -]?Romeo)\b/iu',
            'Aston Martin' => '/\b(Aston|Martin)\b/iu',
            'Audi' => '/\b(Audi)\b/iu',
            'Bentley' => '/\b(Bentley)\b/iu',
            'BMW' => '/\b(BMW)\b/iu',
            'Bugatti' => '/\b(Bugatti)\b/iu',
            'Buick' => '/\b(Buick)\b/iu',
            'Cadillac' => '/\b(Cadillac)\b/iu',
            'Chevrolet' => '/\b(Chevrolet|chevy?)\b/iu',
            'Chrysler' => '/\b(Chrysler)\b/iu',
            'Dodge' => '/\b(Dodge)\b/iu',
            'Ferrari' => '/\b(Ferrari|Ferr)\b/iu',
            'Fiat' => '/\b(Fiat)\b/iu',
            'Ford' => '/\b(Ford)\b/iu',
            'Geo' => '/\b(Geo)\b/iu',
            'GMC' => '/\b(GMC)\b/iu',
            'Honda' => '/\b(Honda)\b/iu',
            'Hummer' => '/\b(Hummer)\b/iu',
            'Hyundai' => '/\b(Hyundai)\b/iu',
            'Infiniti' => '/\b(Infiniti)\b/iu',
            'Isuzu' => '/\b(Isuzu)\b/iu',
            'Jaguar' => '/\b(Jaguar)\b/iu',
            'Jeep' => '/\b(Jeep)\b/iu',
            'Kia' => '/\b(Kia)\b/iu',
            'Lamborghini' => '/\b(Lamborghini|lambo)\b/iu',
            'Land Rover' => '/\b(Land[ -]?Rover)\b/iu',
            'Lexus' => '/\b(Lexus)\b/iu',
            'Lincoln' => '/\b(Lincoln)\b/iu',
            'Lotus' => '/\b(Lotus)\b/iu',
            'Maserati' => '/\b(Maserati)\b/iu',
            'Maybach' => '/\b(Maybach)\b/iu',
            'Mazda' => '/\b(Mazda)\b/iu',
            'McLaren' => '/\b(McLaren)\b/iu',
            'Mercedes-Benz' => '/\b(Mercedes[- ]Benz)\b/iu',
            'Mercury' => '/\b(Mercury)\b/iu',
            'MG' => '/\b(MG)\b/iu',
            'MINI' => '/\b(MINI)\b/iu',
            'Mitsubishi' => '/\b(Mitsubishi)\b/iu',
            'Nissan' => '/\b(Nissan)\b/iu',
            'Oldsmobile' => '/\b(Oldsmobile)\b/iu',
            'Peugeot' => '/\b(Peugeot)\b/iu',
            'Plymouth' => '/\b(Plymouth)\b/iu',
            'Pontiac' => '/\b(Pontiac)\b/iu',
            'Porsche' => '/\b(Porsche)\b/iu',
            'RAM' => '/\b(RAM)\b/iu',
            'Renault' => '/\b(Renault)\b/iu',
            'Rolls-Royce' => '/\b(Rolls[- ]?Royce)\b/iu',
            'Saab' => '/\b(Saab)\b/iu',
            'Saturn' => '/\b(Saturn)\b/iu',
            'Scion' => '/\b(Scion)\b/iu',
            'Smart' => '/\b(Smart)\b/iu',
            'Subaru' => '/\b(Subaru)\b/iu',
            'Suzuki' => '/\b(Suzuki)\b/iu',
            'Tesla' => '/\b(Tesla)\b/iu',
            'Toyota' => '/\b(Toyota)\b/iu',
            'Volkswagen' => '/\b(Volkswagen)\b/iu',
            'Volvo' => '/\b(Volvo)\b/iu',
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
}
