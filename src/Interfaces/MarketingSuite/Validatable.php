<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface Validatable
 *
 * @property string $title
 */
interface Validatable
{
    /**
     * Retrieve the lead type id assigned to the campaign
     *
     * @return int|null
     */
    public function leadTypeId(): ?int;

    /**
     * This method should return if the campaign is utilizing a specific
     * medium. Is it sending letters, sending emails, using facebook carousel,
     * etc.
     *
     * @param string $slug The asset type slug
     *
     * @return bool
     */
    public function medium(string $slug): bool;

    /**
     * Get the portfolio of assets for this campaign
     *
     * @return Asset[]
     */
    public function portfolio(): array;

    /**
     * Get the store id for this campaigns
     *
     * @return int
     */
    public function storeId(): int;
}
