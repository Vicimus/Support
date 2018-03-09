<?php declare(strict_types = 1);

namespace Vicimus\Support\Classes;

use DateTime as Date;
use DateTimeZone;

/**
 * DateTime wrapper
 */
class DateTime extends Date
{
    /**
     * DateTime constructor.
     *
     * @param string            $time     Time to instantiate to
     * @param DateTimeZone|null $timezone Timezone to use
     */
    public function __construct(string $time = 'now', ?DateTimeZone $timezone = null)
    {
        $time = $this->replace($time);
        parent::__construct($time, $timezone);
    }

    /**
     * Replace time zones in a date string
     *
     * @param string $time The string to replace
     * @return string
     */
    protected function replace(string $time): string
    {
        return preg_replace('/\([^)]+\)/', '', $time);
    }
}
