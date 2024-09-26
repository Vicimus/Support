<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface Identifiable
{
    /**
     * Provides an identifier to use with purls
     */
    public function identifier(): string;

    /**
     * Get the primary identification for the entity
     */
    public function primaryId(): ?int;

    /**
     * Some identifiables have short urls
     */
    public function shortUrl(): ?string;
}
