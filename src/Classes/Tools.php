<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use DateTime;

use function array_keys;
use function arsort;
use function count;
use function getdate;
use function implode;
use function key;
use function preg_match;

/**
 * Generic util tools.
 */
class Tools
{
    /**
     * Attempt to detect the date format from a sample of values.
     *
     * @param string[] $values The date values to test.
     *
     * @return string|null
     */
    public static function detectDateFormat(array $values): ?string
    {
        $formatOccurs = [
            'd/m/Y' => 0,
            'd/m/y' => 0,
            'm/d/y' => 0,
            'm/d/Y' => 0,
            'Y/m/d' => 0,
            'd-m-Y' => 0,
            'd-m-y' => 0,
            'm-d-y' => 0,
            'm-d-Y' => 0,
            'Y-m-d' => 0,
        ];

        foreach ($values as $value) {
            foreach ($formatOccurs as $format => $count) {
                $dt = DateTime::createFromFormat($format, $value);
                if ($dt !== false &&
                    DateTime::getLastErrors()['warning_count'] <= 0 &&
                    strpos($dt->format('Y'), '00') !== 0) {
                    $formatOccurs[$format]++;
                }
            }
        }

        if (true) {
            // Reverse sort array by most occurrences
            arsort($formatOccurs);
            $value = key($formatOccurs);
            if ($formatOccurs[$value]) {
                return $value;
            }
        }

        return null;
    }

    /**
     * Detects the date format from a single value, and inserts the occurrence into the
     * passed in array
     *
     * @param string   $value        The value parsed
     * @param string[] $formatOccurs The occurrence map
     *
     * @return void
     */
    public static function detectSingleDateFormat(string $value, array &$formatOccurs): void
    {
        if (!count($formatOccurs)) {
            $formatOccurs = [
                'd/m/Y' => 0,
                'd/m/y' => 0,
                'm/d/y' => 0,
                'm/d/Y' => 0,
                'Y/m/d' => 0,
                'd-m-Y' => 0,
                'd-m-y' => 0,
                'm-d-y' => 0,
                'm-d-Y' => 0,
                'Y-m-d' => 0,
            ];
        }

        foreach ($formatOccurs as $format => $count) {
            $dt = DateTime::createFromFormat($format, $value);
            if ($dt !== false &&
                DateTime::getLastErrors()['warning_count'] <= 0 &&
                strpos($dt->format('Y'), '00') !== 0) {
                $formatOccurs[$format]++;
            }
        }
    }

    /**
     * Get country from state.
     *
     * @param string $input The state input
     *
     * @return null|string
     */
    public static function getCountryFromState(string $input): ?string
    {
        $countries = array_keys(Enums::countries());
        foreach ($countries as $country) {
            $state = Parser::parseState($input, $country);
            if ($state) {
                return $country;
            }
        }

        return null;
    }

    /**
     * Tool for detecting company names.
     *
     * @param string $name The name to check.
     *
     * @return bool Flag for company.
     */
    public static function isCompany(string $name): bool
    {
        $re = [
            '(and|et|body|car(s|e)?|data|inc|ll(p|c)|ont?|can?|name|sales|ventes|direct?)',
            '(sons|daughters|fils|filles)',
            '(american?|canad(a|ian)?|usa|nation(al)?|(pacif|atlant)ic)',
            '(auto(mo|body|sport)?(tive|biles?)?|(invest|manage|equip|improve?)?ments?)',
            '(banks?|credit|works?|legal|lawn?|doctor|health|weekly|news|paper|unit|dept)',
            '(banques?|crédit|légal|gazon|docteur|santé|hebdomadaire|nouvelles|journal)',
            "int(eriors?|ern?)?(nationale?)?(\'l|l)?",
            't[eé]l[eé](com|visions?)?(munications?)?',
            'trans(missions?|port(s|ations?)?)?',
            '(access(ories)?|co(\-)?op([eé]rative)?|(in)?corp(orat)?(ion|ed)?)',
            '(ltd|limited|limitée?)',
            '(construct(ion)?|perform(ance)?|janitorial|masonry|windows|doors|portes|fenêtres)',
            '(dents?|motors?|designs?|graphics?|club|groupe?|(signa|furni)ture)',
            '(com(puters?|pany)?|contract(ing|ors)?|(un)?l(imi)?t(e)?d|tech(nolog)?(y|ies)?)',
            '(info(rmation)?|financ(e|ial|ing)?|serv(ice)?s?|warrant(y|ies)?)',
            '(assoc(iates|iation)?|communicat(e|ions?)|pro(fess)?(io)?(na)?(ls?)?|quality)',
            '(distribut(e|ors|ion)?|innovat(ives?|ions?)?|publi(cations?|shing|shers?)?)',
            '(sys(t[eè]me?s?)?|rent(als?)?|suppl(y|ies)?|truck(s|ing)?)',
            '(consult(ing|ants?)?|enterprises?|offices?|networks?|mechanics?)',
            '(cent(re|er|ral)s?|manheims?|tires?|brothers?|holdings?|brokers?|insurances?)',
            '(industri(al|es)|tint(ing)?|pav(ing|ers)?)',
            '(import(s|ers)?|detail(ers|ing)?|wholesale(rs)?|roof(ing|ers)?)',
            '(ontario|toronto|ottawa|calgary|montr[eé]al|alberta)',
            '(agenc(y|ies)|engine|parts|pièces|repairs?)',
            '(auct|celebrat|collis|installat|educat|solut|promot)ions?',
            '(university|college|school|creative|media|florist|magazine)',
            '(université|collège|école|média|fleuriste|revue)',
            '(business|marketing|exchange|mechanical|advertising|app(s|lications?)?|secur(e|ity))',
            '((east|west|road|water)side|(downs?|global|water)?views?)',
            '(home|street|avenue|district|town(ship)?|village|city|ville)',
            '(account(ants?|ing)?|minist(er|ry)|protect(ion)?|graphics?|leas(e|ing))',
            '(cartage|electric|radiator|prestige|express|powertrain)',
            '(clinic|clinique|shop|magasin|ca(fe|tering)|restaurant|din(ing|er))',
            '(spa|inn|hotel|suites|motel|business|tv|cable|garage|(ware)?house|inventory)',
            '(acura|audi|bmw|buick|chevrolet|cadillac|gmc|chrysler|dodge|jeep|ford|honda)',
            '(hyundai|infiniti|jaguar|kia|(land|rover)|lexus|lincoln|mazda|(mercedes|benz))',
            '(mini|mitsubishi|nissan|porsche|smart|subaru|toyota|volkswagen|volvo|vw)',
        ];

        if (preg_match('/\b(' . implode('|', $re) . ')\b/i', $name)) {
            return true;
        }

        return false;
    }

    /**
     * Return list of latest years starting from current + extra to max size
     * in descending order.
     *
     * @param int $overCurrent The extra years to get over current year.
     * @param int $size        The size of years to return.
     *
     * @return string[]
     */
    public static function latestYears(int $overCurrent = 1, int $size = 20): array
    {
        $curYear = getdate()['year'];
        $startYear = $curYear + $overCurrent;
        $years = [];
        for ($y = $startYear; $y > $startYear - $size; $y--) {
            $years[$y] = $y;
        }

        return $years;
    }
}
