<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Vicimus\Support\Classes\Exports\ExportArtifact;

interface DailyCustomersAdapter
{
    /**
     * @param Collection<int, ExportArtifact> $artifacts
     */
    public function deliver(Collection $artifacts): bool;

    public function filename(Carbon $date): string;

    public function path(): string;

    /**
     * @return int[]
     */
    public function stores(): array;
}
