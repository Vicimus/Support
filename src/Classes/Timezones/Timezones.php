<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes\Timezones;

use DateTime;
use DateTimeZone;
use Illuminate\Support\Collection;

/**
 * Class Timezones
 */
class Timezones
{
    /**
     * Get all timezones
     *
     * @return Collection
     */
    public function all(): Collection
    {
        $payload = [];
        $timezones = DateTimeZone::listIdentifiers();
        foreach ($timezones as $timezone) {
            $date = new DateTime();
            $date->setTimezone(new DateTimeZone($timezone));
            $offset = $date->getOffset() / 3600;
            $operator = ($offset > 0) ? '+' : '';

            $display = sprintf('(UTC %s%s) %s', $operator, $offset, $timezone);
            $payload[] = new Timezone([
                'offset' => $offset,
                'timezone' => $timezone,
                'display' => $display,
            ]);
        }

        return new Collection($payload);
    }
}
