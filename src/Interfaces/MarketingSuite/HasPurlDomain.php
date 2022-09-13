<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vicimus\Support\Interfaces\Eloquent;

/**
 * Interface HasPurlDomain
 *
 * @property Eloquent|PurlDomainContract $domain
 */
interface HasPurlDomain
{
    /**
     * A campaign has a purl domain
     *
     * @return BelongsTo
     */
    public function domain(): BelongsTo;

    /**
     * Retrieve the purl domain to use for the instance
     * @return PurlDomainContract
     */
    public function getDomain(): PurlDomainContract;

    /**
     * The purl domain id
     * @return int|null
     */
    public function purlDomainId(): ?int;

    /**
     * Get the store id for this campaigns
     * @return int
     */
    public function storeId(): int;
}
