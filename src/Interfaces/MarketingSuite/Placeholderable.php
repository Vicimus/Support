<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

interface Placeholderable
{
    public function campaignId(): int;

    public function campaignTitle(): string;

    public function oem(): string;

    public function purlDomainId(): ?int;
}
