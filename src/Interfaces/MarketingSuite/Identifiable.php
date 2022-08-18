<?php declare(strict_types = 1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

/**
 * Interface Identifiable
 */
interface Identifiable
{
    /**
     * Provides an identifier to use with purls
     * @return string
     */
    public function identifier(): string;

    /**
     * Get the primary identification for the entity
     *
     * @return int
     */
    public function primaryId(): ?int;

    /**
     * Some identifiables have short urls
     * @return string|null
     */
    public function shortUrl(): ?string;
}
