<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\Filtering;

use JsonSerializable;

/**
 * Interface Stats
 */
interface Stats extends JsonSerializable
{
    /**
     * Return all stats as an array of data
     * @return mixed[]
     */
    public function toArray(): array;
}
