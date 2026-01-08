<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite\Exports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use League\Csv\Writer;
use Vicimus\Support\Classes\Exports\ExportArtifact;

interface DailyCustomersAdapter
{
    /**
     * @param Collection<int, ExportArtifact> $artifacts
     */
    public function deliver(Collection $artifacts): bool;

    public function filename(Carbon $date): string;

    public function key(): string;

    public function normalizer(): DailyCustomersNormalizer;

    /**
     * @return int[]
     */
    public function stores(): array;

    /**
     * @param Collection<int, object> $customers
     */
    public function write(Writer $csv, Collection $customers): void;
}
