<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes\Timezones;

use DateTimeZone;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Support\Collection;
use Vicimus\Support\Classes\DateTime;

/**
 * Class Timezones
 */
class Timezones
{
    /**
     * The cache repository
     *
     */
    private Repository $cache;

    /**
     * Timezones constructor.
     *
     * @param Repository $cache The cache repository
     */
    public function __construct(Repository $cache)
    {
        $this->cache = $cache;
    }

    /**
     * Get all timezones
     *
     */
    public function all(): Collection
    {
        return $this->cache->rememberForever('timezones', fn () => $this->payload());
    }

    /**
     * Get the timezone payload
     *
     * @return Collection|Timezone[]
     */
    public function payload(): Collection
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

        usort($payload, static function (Timezone $timezoneA, Timezone $timezoneB): int {
            if ($timezoneA->offset === $timezoneB->offset) {
                return 0;
            }

            return ($timezoneA->offset > $timezoneB->offset) ? 1 : -1;
        });

        return new Collection($payload);
    }
}
