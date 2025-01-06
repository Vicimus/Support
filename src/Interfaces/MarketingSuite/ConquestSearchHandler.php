<?php

declare(strict_types=1);

namespace Vicimus\Support\Interfaces\MarketingSuite;

use Vicimus\Support\Classes\AutocompleteItem;

interface ConquestSearchHandler
{
    /**
     * Search for a term
     *
     * @return AutocompleteItem[]
     */
    public function search(string $term): array;
}
