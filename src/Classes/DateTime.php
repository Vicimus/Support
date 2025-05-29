<?php

declare(strict_types=1);

namespace Vicimus\Support\Classes;

use DateTime as Date;
use DateTimeZone;

class DateTime extends Date
{
    public function __construct(
        string $time = 'now',
        ?DateTimeZone $timezone = null
    ) {
        if ($time !== 'now') {
            $time = $this->replace($time);
        }

        parent::__construct($time, $timezone);
    }

    protected function replace(string $time): string
    {
        return preg_replace('/\([^)]+\)/', '', $time);
    }
}
