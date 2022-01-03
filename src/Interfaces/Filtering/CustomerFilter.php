<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\Filtering;

use Vicimus\Support\Classes\ImmutableObject;

/**
 * Class CustomerFilter, packages properties used in querying customers
 *
 * @property int $limit
 * @property int $page
 * @property bool $stats
 * @property string $search
 * @property string $type
 * @property bool $excluded
 * @property string $embed
 */
class CustomerFilter extends ImmutableObject
{
    /**
     * CustomerFilter constructor.
     * @param int|null    $limit  The limit per page, or total if not paginating
     * @param int|null    $page   The current page
     * @param string|null $type   The type of customer to filter by (all, email, letter)
     * @param string|null $search Additional search string
     */
    public function __construct(?int $limit = null, ?int $page = null, ?string $type = null, ?string $search = null)
    {
        $payload = [
            'limit' => $limit,
            'page' => $page,
            'search' => $search,
            'stats' => false,
            'type' => $type,
            'excluded' => false,
            'embed' => 'vehicles',
        ];

        parent::__construct($payload);
    }

    /**
     * Set the relationships to embed
     *
     * @param string $embed The relationships to embed, comma separated
     * @return void
     */
    public function setEmbed(string $embed): void
    {
        $this->attributes['embed'] = $embed;
    }

    /**
     * Set the return type of the customer filter
     *
     * @param bool $wantsStats Indicates if the return will want stats included
     *
     * @return void
     */
    public function setStats(bool $wantsStats): void
    {
        $this->attributes['stats'] = $wantsStats;
    }

    /**
     * Set excluded to true
     *
     * @return self
     */
    public function withExclusions(): self
    {
        $this->attributes['excluded'] = true;
        return $this;
    }
}
